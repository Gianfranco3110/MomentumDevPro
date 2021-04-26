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
    <CSidebarBrand style="text-decoration:none;color:black" class="d-md-none d-lg-none" to="/">
      <h3>YareStylo</h3>
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