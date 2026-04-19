<template>
  <div class="mensajeria-container">
    <loading-overlay :active="loading" :is-full-page="true" loader="bars" />

    <CCard>
      <CCardHeader class="botonesP text-white text-center">
        <b>MENSAJERÍA — CONVERSACIONES</b>
      </CCardHeader>
      <CCardBody class="p-0">
        <div v-if="conversations.length === 0 && !loading" class="text-center py-5 text-muted">
          No hay conversaciones aún.
        </div>

        <ul class="conversation-list list-unstyled mb-0">
          <li
            v-for="conv in conversations"
            :key="conv.user_id"
            class="conversation-item d-flex align-items-center px-3 py-3"
            @click="openChat(conv.user_id)"
          >
            <div class="conv-avatar mr-3">
              <img
                :src="conv.photo ? ($apiAdress + conv.photo) : 'img/avatars/icon_user.png'"
                class="rounded-circle"
                width="46"
                height="46"
                style="object-fit:cover;"
              />
            </div>

            <div class="conv-info flex-grow-1 overflow-hidden">
              <div class="d-flex justify-content-between align-items-center">
                <span class="conv-name font-weight-bold">{{ conv.name }}</span>
                <small class="conv-time text-muted">{{ formatTime(conv.last_time) }}</small>
              </div>
              <div class="d-flex justify-content-between align-items-center mt-1">
                <span class="conv-preview text-muted text-truncate" style="max-width:220px;">
                  {{ conv.last_message }}
                </span>
                <span
                  v-if="conv.unread > 0"
                  class="badge-nuevo ml-2"
                >
                  {{ conv.unread }} NUEVO<span v-if="conv.unread > 1">S</span>
                </span>
              </div>
            </div>
          </li>
        </ul>
      </CCardBody>
    </CCard>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'AdminMensajeria',
  data() {
    return {
      conversations: [],
      loading: false,
      pollInterval: null,
    };
  },
  methods: {
    fetchConversations() {
      const token = localStorage.getItem('api_token');
      axios
        .get(this.$apiAdress + '/api/messages/conversations?token=' + token)
        .then((res) => {
          this.conversations = res.data;
          this.loading = false;
        })
        .catch(() => {
          this.loading = false;
        });
    },
    openChat(userId) {
      this.$router.push({ path: '/mensajeria/chat/' + userId });
    },
    formatTime(ts) {
      if (!ts) return '';
      const d = new Date(ts);
      const now = new Date();
      const diffDays = Math.floor((now - d) / 86400000);
      if (diffDays === 0) {
        return d.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
      }
      if (diffDays === 1) return 'Ayer';
      return d.toLocaleDateString();
    },
  },
  mounted() {
    this.loading = true;
    this.fetchConversations();
    this.pollInterval = setInterval(this.fetchConversations, 10000);
  },
  beforeDestroy() {
    clearInterval(this.pollInterval);
  },
};
</script>

<style scoped>
.mensajeria-container {
  max-width: 700px;
  margin: 2rem auto;
}
.conversation-item {
  border-bottom: 1px solid #f0f0f0;
  cursor: pointer;
  transition: background 0.15s;
}
.conversation-item:hover {
  background: #f8f8f8;
}
.conv-name {
  font-size: 0.95rem;
}
.conv-preview {
  font-size: 0.82rem;
}
.conv-time {
  font-size: 0.75rem;
  white-space: nowrap;
}
.badge-nuevo {
  background: #DCBA0F;
  color: #000;
  font-size: 0.68rem;
  font-weight: 700;
  border-radius: 20px;
  padding: 2px 8px;
  white-space: nowrap;
}
</style>
