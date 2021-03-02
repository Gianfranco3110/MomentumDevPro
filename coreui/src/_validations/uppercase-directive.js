export default {
    uppercase: {
      bind(el, _, vnode) {
        el.addEventListener('input', (e) => {
          e.target.value = e.target.value.toUpperCase()
          vnode.componentInstance.$emit('input', e.target.value.toUpperCase())
        });
      }
    }
  }