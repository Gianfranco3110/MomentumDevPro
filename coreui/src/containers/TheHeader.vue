<template>
  <CHeader fixed with-subheader light>
    <CToggler
      in-header
      class="ml-3 d-lg-none"
      @click="$store.commit('toggleSidebarMobile')"
    />
    <CToggler
      in-header
      class="ml-3 d-md-down-none"
      @click="$store.commit('toggleSidebarDesktop')"
    />
    <div class="floating-button">
      <a
        target="_blank"
        href="https://api.whatsapp.com/send?phone=584245124623&text=*Hola Yaritzy*%0A*Información:* Estoy interesada en adquirir uno de tus cursos"
        class="btn botonesP d-inline-flex align-items-center"
        style="color:#ffffff !important; font-weight:600; letter-spacing:0.5px; padding: 10px 18px; border-radius: 30px; box-shadow: 0 4px 12px rgba(0,0,0,0.5);"
      >
        <span class="mr-2" style="color:#ffffff !important; white-space: nowrap;">Contacto</span>
        <i class="fab fa-whatsapp" style="color:#25D366 !important; font-size:1.3rem;"></i>
      </a>
    </div>
    <CSidebarBrand style="text-decoration:none;color:black" class="d-md-none d-lg-none" to="/">
      <h5>YARIESTILOS PMU</h5>
    </CSidebarBrand>

    <CMenu/>

    <!-- Zona derecha: campanita + usuario alineados -->
    <div style="display:flex; align-items:center; margin-right:20px; gap:4px; height:56px;">

      <!-- Campanita -->
      <div
        @click.stop="goToMensajeria"
        style="position:relative; cursor:pointer; display:flex; align-items:center; padding:0 10px;"
      >
        <CIcon name="cil-bell" style="font-size:1.5rem; color:#DCBA0F;" />
        <span
          v-show="unreadCount > 0"
          style="
            position:absolute;
            top:2px;
            right:2px;
            background:#e55353;
            color:#fff;
            border-radius:10px;
            min-width:18px;
            height:18px;
            font-size:0.72rem;
            font-weight:bold;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:0 4px;
            box-shadow:0 1px 4px rgba(0,0,0,0.3);
            pointer-events:none;
            z-index:9999;
            line-height:1;
          "
        >{{ unreadCount }}</span>
      </div>

      <!-- Nombre + foto -->
      <CHeaderNav>
        <TheHeaderDropdownAccnt/>
      </CHeaderNav>

    </div>
    
    <CSubheader class="px-3">
      <CBreadcrumbRouter class="border-0 mb-0"/>
    </CSubheader>
  </CHeader>
</template>

<script>
import axios from 'axios'
import CMenu from './Menu'
import TheHeaderDropdownAccnt from './TheHeaderDropdownAccnt'

export default {
  name: 'TheHeader',
  components: {
    TheHeaderDropdownAccnt,
    CMenu
  },
  data() {
    return {
      unreadCount: 0,
      pollInterval: null,
    }
  },
  mounted() {
    this.fetchUnreadCount()
    this.pollInterval = setInterval(this.fetchUnreadCount, 5000)
    this.$bus.$on('messages-read', this.fetchUnreadCount)
  },
  beforeDestroy() {
    clearInterval(this.pollInterval)
    this.$bus.$off('messages-read', this.fetchUnreadCount)
  },
  methods: {
    fetchUnreadCount() {
      const token = localStorage.getItem('api_token')
      if (!token) return
      axios.get(this.$apiAdress + '/api/messages/unread-count?token=' + token)
        .then(res => {
          const count = parseInt(res.data.unread, 10)
          this.unreadCount = isNaN(count) || count < 0 ? 0 : count
        })
        .catch(() => {})
    },
    goToMensajeria() {
      const roles = localStorage.getItem('roles') || ''
      const isAdmin = roles.includes('admin')
      const target = isAdmin ? '/mensajeria' : '/mensajes'
      if (this.$router.currentRoute.path !== target) {
        this.$router.push(target)
      }
    }
  }
}
</script>