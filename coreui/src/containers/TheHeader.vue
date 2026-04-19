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
      <h5>YariEstylosPmu</h5>
    </CSidebarBrand>

    <CMenu/>
  
    <CHeaderNav class="mr-5">     
      <TheHeaderDropdownAccnt/>
    </CHeaderNav>
    
    <CSubheader class="px-3">
      <CBreadcrumbRouter class="border-0 mb-0"/>
    </CSubheader>
  </CHeader>
</template>

<script>
import CMenu from './Menu'
import TheHeaderDropdownAccnt from './TheHeaderDropdownAccnt'

export default {
  name: 'TheHeader',
  components: {
    TheHeaderDropdownAccnt,
    CMenu
  }
}
</script>