import Vue from 'vue'
import Router from 'vue-router'

// Containers
const TheContainer = () => import('@/containers/TheContainer')

// Views
const Dashboard = () => import('@/views/Dashboard')

const Colors = () => import('@/views/theme/Colors')
const Typography = () => import('@/views/theme/Typography')

const Charts = () => import('@/views/charts/Charts')
const Widgets = () => import('@/views/widgets/Widgets')

// Views - Components

// Views - Buttons
// Views - Icons

// Views - Notifications
const Alerts = () => import('@/views/notifications/Alerts')
const Badges = () => import('@/views/notifications/Badges')
const Modals = () => import('@/views/notifications/Modals')

// Views - Pages
const Page404 = () => import('@/views/pages/Page404')
const Page500 = () => import('@/views/pages/Page500')
const Login = () => import('@/views/pages/Login')
const Register = () => import('@/views/pages/Register')
const Index = () => import('@/views/pages/Index')

// Users
const Users = () => import('@/views/users/Users')
const User = () => import('@/views/users/User')
const EditUser = () => import('@/views/users/EditUser')
const UserAjustes = () => import('@/views/users/UserAjustes')
const MisCursos = () => import('@/views/users/MisCursos')

//Notes
const Notes = () => import('@/views/notes/Notes')
const Note = () => import('@/views/notes/Note')
const EditNote = () => import('@/views/notes/EditNote')
const CreateNote = () => import('@/views/notes/CreateNote')

//Products
const products = () => import('@/views/products/index')

//Cursos
const cursos = () => import('@/views/cursos/index')

//Cursos-Video
const videos = () => import('@/views/videos/index')

//test
const test = () => import('@/views/test/index')

//CONSTANTE PARA REGISTRAR USUARIOS DESDE EL DASHBOARD
const registro = () => import('@/views/RegistroAdmin/index')

//Roles
const Roles = () => import('@/views/roles/Roles')
const Role = () => import('@/views/roles/Role')
const EditRole = () => import('@/views/roles/EditRole')
const CreateRole = () => import('@/views/roles/CreateRole')

//Bread
const Breads = () => import('@/views/bread/Breads')
const Bread = () => import('@/views/bread/Bread')
const EditBread = () => import('@/views/bread/EditBread')
const CreateBread = () => import('@/views/bread/CreateBread')
const DeleteBread = () => import('@/views/bread/DeleteBread')

//Resources
const Resources = () => import('@/views/resources/Resources')
const CreateResource = () => import('@/views/resources/CreateResources')
const Resource = () => import('@/views/resources/Resource')
const EditResource = () => import('@/views/resources/EditResource')
const DeleteResource = () => import('@/views/resources/DeleteResource')

//Email
const Emails        = () => import('@/views/email/Emails')
const CreateEmail   = () => import('@/views/email/CreateEmail')
const EditEmail     = () => import('@/views/email/EditEmail')
const ShowEmail     = () => import('@/views/email/ShowEmail')
const SendEmail     = () => import('@/views/email/SendEmail')

const Menus       = () => import('@/views/menu/MenuIndex')
const CreateMenu  = () => import('@/views/menu/CreateMenu')
const EditMenu    = () => import('@/views/menu/EditMenu')
const DeleteMenu  = () => import('@/views/menu/DeleteMenu')

const MenuElements = () => import('@/views/menuElements/ElementsIndex')
const CreateMenuElement = () => import('@/views/menuElements/CreateMenuElement')
const EditMenuElement = () => import('@/views/menuElements/EditMenuElement')
const ShowMenuElement = () => import('@/views/menuElements/ShowMenuElement')
const DeleteMenuElement = () => import('@/views/menuElements/DeleteMenuElement')

const Media = () => import('@/views/media/Media')




Vue.use(Router)

let router = new Router({
  mode: 'hash', // https://router.vuejs.org/api/#mode
  linkActiveClass: 'active',
  scrollBehavior: () => ({ y: 0 }),
  routes: configRoutes()
})


router.beforeEach((to, from, next) => {
  let roles = localStorage.getItem("roles");
  if(roles != null){
    roles = roles.split(',')
  }
  if(to.matched.some(record => record.meta.requiresAdmin)) {
    if(roles != null && roles.indexOf('admin') >= 0 ){
      next()
    }else{
      next({
        path: '/login',
        params: { nextUrl: to.fullPath }
      })
    }
  }else if(to.matched.some(record => record.meta.requiresUser)) {
    if(roles != null && roles.indexOf('user') >= 0 ){
      next()
    }else{
      next({
        path: '/login',
        params: { nextUrl: to.fullPath }
      })
    }
  }else{
    next()
  }
})

export default router

function configRoutes () {
  return [
    {
      path: "/index",
      component: Index,
      alias: "/"  
    },
    {
      path: '/',
      redirect: '/dashboard',
      name: 'Home',
      component: TheContainer,
      children: [
        {
          path: 'media',
          name: 'Media',
          component: Media,
          meta:{
            requiresAdmin: true
          }
        },
        {
          path: 'dashboard',
          name: 'Dashboard',
          component: Dashboard
        },
        {
          path: 'colors',
          name: 'Colors',
          component: Colors,
          meta:{
            requiresUser: true
          }
        },
        {
          path: 'typography',
          name: 'Typography',
          component: Typography,
          meta:{
            requiresUser: true
          }
        },
        {
          path: 'charts',
          name: 'Charts',
          component: Charts,
          meta:{
            requiresUser: true
          }
        },
        {
          path: 'widgets',
          name: 'Widgets',
          component: Widgets,
          meta:{
            requiresUser: true
          }
        },
        {
          path: 'menu',
          meta: { label: 'Menu'},
          component: {
            render (c) { return c('router-view') }
          },
          children: [
            {
              path: '',
              component: Menus,
              meta:{
                requiresAdmin: true
              }
            },
            {
              path: 'create',
              meta: { label: 'Create Menu' },
              name: 'CreateMenu',
              component: CreateMenu,
              meta:{
                requiresAdmin: true
              }
            },
            {
              path: ':id/edit',
              meta: { label: 'Edit Menu' },
              name: 'EditMenu',
              component: EditMenu,
              meta:{
                requiresAdmin: true
              }
            },
            {
              path: ':id/delete',
              meta: { label: 'Delete Menu' },
              name: 'DeleteMenu',
              component: DeleteMenu,
              meta:{
                requiresAdmin: true
              }
            },
          ]
        },
        {
          path: 'menuelement',
          meta: { label: 'MenuElement'},
          component: {
            render (c) { return c('router-view') }
          },
          children: [
            {
              path: ':menu/menuelement',
              component: MenuElements,
              meta:{
                requiresAdmin: true
              }
            },
            {
              path: ':menu/menuelement/create',
              meta: { label: 'Create Menu Element' },
              name: 'Create Menu Element',
              component: CreateMenuElement,
              meta:{
                requiresAdmin: true
              }
            },
            {
              path: ':menu/menuelement/:id',
              meta: { label: 'Menu Element Details'},
              name: 'Menu Element',
              component: ShowMenuElement,
              meta:{
                requiresAdmin: true
              }
            },
            {
              path: ':menu/menuelement/:id/edit',
              meta: { label: 'Edit Menu Element' },
              name: 'Edit Menu Element',
              component: EditMenuElement,
              meta:{
                requiresAdmin: true
              }
            },
            {
              path: ':menu/menuelement/:id/delete',
              meta: { label: 'Delete Menu Element' },
              name: 'Delete Menu Element',
              component: DeleteMenuElement,
              meta:{
                requiresAdmin: true
              }
            },
          ]
        },
        {
          path: 'users',
          meta: { label: 'Users'},
          component: {
            render (c) { return c('router-view') }
          },
          children: [
            {
              path: '',
              component: Users,
              meta:{
                requiresAdmin: true
              }
            },
            {
              path: ':id',
              meta: { label: 'User Details'},
              name: 'User',
              component: User,
              meta:{
                requiresAdmin: true
              }
            },
            {
              path: ':id/edit',
              meta: { label: 'Edit User' },
              name: 'Edit User',
              component: EditUser,
              meta:{
                requiresAdmin: true
              }
            },
            {
              path: '/settings',
              name: 'settings',
              component: UserAjustes,
            },
          ]
        },
        {
          path: 'notes',
          meta: { label: 'Notes'},
          component: {
            render (c) { return c('router-view') }
          },
          children: [
            {
              path: '',
              component: Notes,
              meta:{
                requiresUser: true
              }
            },
            {
              path: 'create',
              meta: { label: 'Create Note' },
              name: 'Create Note',
              component: CreateNote,
              meta:{
                requiresUser: true
              }
            },
            {
              path: ':id',
              meta: { label: 'Note Details'},
              name: 'Note',
              component: Note,
              meta:{
                requiresUser: true
              }
            },
            {
              path: ':id/edit',
              meta: { label: 'Edit Note' },
              name: 'Edit Note',
              component: EditNote,
              meta:{
                requiresUser: true
              }
            },
          ]
        },
        //Ruta de cursos
        {
          path: 'cursos',
          meta: { label: 'cursos'},
          component: {
            render (c) { return c('router-view') }
          },
          children :[
            {
              path: '',
              component:cursos,
            }
          ]
        },
        //Ruta de Mis Cursos
        {
          path: 'mis-cursos',
          meta: { label: 'Mis Cursos'},
          component: {
            render (c) { return c('router-view') }
          },
          children :[
            {
              path: '',
              component:MisCursos,
            }
          ]
        },
        //Ruta de Products
        {
          path: 'products',
          meta: { label: 'products'},
          component: {
            render (c) { return c('router-view') }
          },
          children :[
            {
              path: '',
              component:products,
            }
          ]
        },
        {
          path: 'videos',
          meta: { label: 'videos'},
          component: {
            render (c) { return c('router-view') }
          },
          children :[
            {
              path: '',
              component:videos,
            }
          ]
        },
        {
          path: 'test',
          meta: { label: 'Test'},
          component: {
            render (c) { return c('router-view') }
          },
          children :[
            {
              path: '',
              component:test,
            }
          ]
        },
        //RUTA PARA CREAR USUARIOS DESDE EL DASHBOARD
        {
          path: 'registro',
          meta: { label: 'registro'},
          component: {
            render (c) { return c('router-view') }
          },
          children :[
            {
              path: '',
              component:registro,
              meta:{
                requiresAdmin: true
              }
            }
          ]
        },
        {
          path: 'roles',
          meta: { label: 'Roles'},
          component: {
            render (c) { return c('router-view') }
          },
          children: [
            {
              path: '',
              component: Roles,
              meta:{
                requiresAdmin: true
              }
            },
            {
              path: 'create',
              meta: { label: 'Create Role' },
              name: 'Create Role',
              component: CreateRole,
              meta:{
                requiresAdmin: true
              }
            },
            {
              path: ':id',
              meta: { label: 'Role Details'},
              name: 'Role',
              component: Role,
              meta:{
                requiresAdmin: true
              }
            },
            {
              path: ':id/edit',
              meta: { label: 'Edit Role' },
              name: 'Edit Role',
              component: EditRole,
              meta:{
                requiresAdmin: true
              }
            },
          ]
        },
        {
          path: 'bread',
          meta: { label: 'Bread'},
          component: {
            render (c) { return c('router-view') }
          },
          children: [
            {
              path: '',
              component: Breads,
              meta:{
                requiresAdmin: true
              }
            },
            {
              path: 'create',
              meta: { label: 'Create Bread' },
              name: 'CreateBread',
              component: CreateBread,
              meta:{
                requiresAdmin: true
              }
            },
            {
              path: ':id',
              meta: { label: 'Bread Details'},
              name: 'Bread',
              component: Bread,
              meta:{
                requiresAdmin: true
              }
            },
            {
              path: ':id/edit',
              meta: { label: 'Edit Bread' },
              name: 'Edit Bread',
              component: EditBread,
              meta:{
                requiresAdmin: true
              }
            },
            {
              path: ':id/delete',
              meta: { label: 'Delete Bread' },
              name: 'Delete Bread',
              component: DeleteBread,
              meta:{
                requiresAdmin: true
              }
            },
          ]
        },
        {
          path: 'email',
          meta: { label: 'Emails'},
          component: {
            render (c) { return c('router-view') }
          },
          children: [
            {
              path: '',
              component: Emails,
              meta:{
                requiresAdmin: true
              }
            },
            {
              path: 'create',
              meta: { label: 'Create Email Template' },
              name: 'Create Email Template',
              component: CreateEmail,
              meta:{
                requiresAdmin: true
              }
            },
            {
              path: ':id',
              meta: { label: 'Show Email Template'},
              name: 'Show Email Tempalte',
              component: ShowEmail,
              meta:{
                requiresAdmin: true
              }
            },
            {
              path: ':id/edit',
              meta: { label: 'Edit Email Tempalate' },
              name: 'Edit Email Template',
              component: EditEmail,
              meta:{
                requiresAdmin: true
              }
            },
            {
              path: ':id/sendEmail',
              meta: { label: 'Send Email' },
              name: 'Send Email',
              component: SendEmail,
              meta:{
                requiresAdmin: true
              }
            },
          ]
        },
        {
          path: 'resource',
          meta: { label: 'Resources'},
          component: {
            render (c) { return c('router-view') }
          },
          children: [
            {
              path: ':bread/resource',
              component: Resources,
            },
            {
              path: ':bread/resource/create',
              meta: { label: 'Create Resource' },
              name: 'CreateResource',
              component: CreateResource
            },
            {
              path: ':bread/resource/:id',
              meta: { label: 'Resource Details'},
              name: 'Resource',
              component: Resource,
            },
            {
              path: ':bread/resource/:id/edit',
              meta: { label: 'Edit Resource' },
              name: 'Edit Resource',
              component: EditResource
            },
            {
              path: ':bread/resource/:id/delete',
              meta: { label: 'Delete Resource' },
              name: 'Delete Resource',
              component: DeleteResource
            },
          ]
        },
        {
          path: 'base',
          redirect: '/base/cards',
          name: 'Base',
          component: {
            render (c) { return c('router-view') }
          },
        },
        {
          path: 'notifications',
          redirect: '/notifications/alerts',
          name: 'Notifications',
          component: {
            render (c) { return c('router-view') }
          },
          children: [
            {
              path: 'alerts',
              name: 'Alerts',
              component: Alerts,
              meta:{
                requiresUser: true
              }
            },
            {
              path: 'badge',
              name: 'Badge',
              component: Badges,
              meta:{
                requiresUser: true
              }
            },
            {
              path: 'modals',
              name: 'Modals',
              component: Modals,
              meta:{
                requiresUser: true
              }
            }
          ]
        }
      ]
    },
    {
      path: '/pages',
      redirect: '/pages/404',
      name: 'Pages',
      component: {
        render (c) { return c('router-view') }
      },
      children: [
        {
          path: '404',
          name: 'Page404',
          component: Page404
        },
        {
          path: '500',
          name: 'Page500',
          component: Page500
        },
      ]
    },
    {
      path: '/login',
      name: 'Auth',
      component: Login
    },
    {
      path: '/register',
      name: 'Register',
      component: Register
    },
    {
      path: '*',
      name: '404',
      component: Page404
    },
  ]
}
