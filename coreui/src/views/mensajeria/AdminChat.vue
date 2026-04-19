<template>
  <div class="chat-wrapper">
    <loading-overlay :active="loading" :is-full-page="true" loader="bars" />

    <!-- Header del chat -->
    <CCard class="mb-0">
      <CCardHeader class="botonesP text-white d-flex align-items-center">
        <span
          class="mr-3"
          style="cursor:pointer; font-size:1.2rem;"
          @click="$router.push('/mensajeria')"
        >&#8592;</span>
        <img
          :src="otherUser.photo ? ($apiAdress + otherUser.photo) : 'img/avatars/icon_user.png'"
          class="rounded-circle mr-2"
          width="36"
          height="36"
          style="object-fit:cover;"
        />
        <b>{{ otherUser.name }}</b>
      </CCardHeader>

      <!-- Área de mensajes -->
      <CCardBody class="chat-body p-3" ref="chatBody">
        <div v-if="messages.length === 0 && !loading" class="text-center text-muted py-4">
          No hay mensajes aún. ¡Inicia la conversación!
        </div>

        <div
          v-for="msg in messages"
          :key="msg.id"
          class="msg-row"
          :class="msg.mine ? 'msg-mine' : 'msg-theirs'"
        >
          <img
            :src="msg.sender_photo ? ($apiAdress + msg.sender_photo) : 'img/avatars/icon_user.png'"
            class="chat-avatar"
            :class="msg.mine ? 'ml-2' : 'mr-2'"
            width="36"
            height="36"
            style="object-fit:cover; border-radius:50%; margin-left:8px; margin-right:8px;"
            :alt="msg.mine ? 'Admin foto' : 'Usuario foto'"
          />
          <div class="msg-bubble">
            <span>{{ msg.body }}</span>
            <small class="msg-time">{{ formatTime(msg.created_at) }}</small>
          </div>
        </div>
      </CCardBody>

      <!-- Input -->
      <CCardFooter class="p-2">
        <div class="d-flex align-items-end" style="gap:8px;">
          <textarea
            v-model="newMessage"
            class="form-control"
            placeholder="Escribe un mensaje..."
            rows="2"
            style="resize:vertical; min-height:40px; max-height:120px;"
            @keyup.enter="sendMessage"
          ></textarea>
          <button
            class="btn botonesCan text-white px-4 py-2"
            style="font-size:1.1rem; min-width:90px; min-height:44px;"
            :disabled="!newMessage.trim() || sending"
            @click="sendMessage"
          >
            {{ sending ? '...' : 'Enviar' }}
          </button>
        </div>
      </CCardFooter>
    </CCard>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'AdminChat',
  data() {
    return {
      messages: [],
      newMessage: '',
      sending: false,
      loading: false,
      otherUser: { name: '', photo: null },
      pollInterval: null,
      adminPhoto: localStorage.getItem('photo_url') || 'img/avatars/icon_user.png',
    };
  },
  computed: {
    userId() {
      return this.$route.params.userId;
    },
    token() {
      return localStorage.getItem('api_token');
    },
  },
  methods: {
    fetchUser() {
      axios
        .get(this.$apiAdress + '/api/users/' + this.userId + '?token=' + this.token)
        .then((res) => {
          this.otherUser = { name: res.data.name || '', photo: res.data.photo || null };
        })
        .catch(() => {});
    },
    fetchMessages() {
      axios
        .get(this.$apiAdress + '/api/messages/' + this.userId + '?token=' + this.token)
        .then((res) => {
          this.messages = res.data;
          this.loading = false;
          this.$nextTick(this.scrollToBottom);
        })
        .catch(() => {
          this.loading = false;
        });
    },
    markRead() {
      axios
        .put(this.$apiAdress + '/api/messages/' + this.userId + '/read?token=' + this.token)
        .then(() => {
          this.$bus.$emit('messages-read');
        })
        .catch(() => {});
    },
    sendMessage() {
      const body = this.newMessage.trim();
      if (!body) return;
      this.sending = true;
      axios
        .post(this.$apiAdress + '/api/messages?token=' + this.token, {
          receiver_id: parseInt(this.userId),
          body,
        })
        .then((res) => {
          this.messages.push(res.data);
          this.newMessage = '';
          this.sending = false;
          this.$nextTick(this.scrollToBottom);
        })
        .catch(() => {
          this.sending = false;
        });
    },
    scrollToBottom() {
      const el = this.$refs.chatBody;
      if (el) el.scrollTop = el.scrollHeight;
    },
    formatTime(ts) {
      if (!ts) return '';
      return new Date(ts).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    },
  },
  mounted() {
    this.loading = true;
    this.fetchUser();
    this.fetchMessages();
    this.markRead();
    this.pollInterval = setInterval(() => {
      this.fetchMessages();
      this.markRead();
    }, 10000);
  },
  beforeDestroy() {
    clearInterval(this.pollInterval);
  },
};
</script>

<style scoped>
.chat-wrapper {
  max-width: 700px;
  margin: 2rem auto;
}
.chat-body {
  height: 420px;
  overflow-y: auto;
  display: flex;
  flex-direction: column;
  gap: 8px;
  background: #f4f4f4;
}
.msg-row {
  display: flex;
}
.msg-mine {
  justify-content: flex-end;
}
.msg-theirs {
  justify-content: flex-start;
}
.msg-bubble {
  max-width: 70%;
  padding: 8px 12px;
  border-radius: 16px;
  font-size: 0.9rem;
  display: flex;
  flex-direction: column;
  gap: 4px;
}
.msg-mine .msg-bubble {
  background: #DCBA0F;
  color: #000;
  border-bottom-right-radius: 4px;
}
.msg-theirs .msg-bubble {
  background: #fff;
  color: #222;
  border-bottom-left-radius: 4px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}
.msg-time {
  font-size: 0.68rem;
  opacity: 0.7;
  align-self: flex-end;
}
</style>
