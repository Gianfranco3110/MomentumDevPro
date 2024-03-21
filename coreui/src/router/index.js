import Vue from "vue";
import Router from "vue-router";

// Containers
const TheContainer = () => import("@/containers/TheContainer");

// Views
const Dashboard = () => import("@/views/Dashboard");

//Detalle del curso
const detailcoruse = () => import("@/views/pages/courseDetail");

// Views - Pages
const Page404 = () => import("@/views/pages/Page404");
const Page500 = () => import("@/views/pages/Page500");
const Login = () => import("@/views/pages/Login");
const Register = () => import("@/views/pages/Register");
const Index = () => import("@/views/pages/Index");

// Users
const Users = () => import("@/views/users/Users");
const User = () => import("@/views/users/User");
const EditUser = () => import("@/views/users/EditUser");
const UserAjustes = () => import("@/views/users/UserAjustes");
const MisCursos = () => import("@/views/users/MisCursos");
const UserCourses = () => import("@/views/users/user-courses");

//Products
const products = () => import("@/views/products/index");

//Cursos
const cursos = () => import("@/views/cursos/index");

//CONSTANTE PARA REGISTRAR USUARIOS DESDE EL DASHBOARD
const registro = () => import("@/views/RegistroAdmin/index");

//configuracion de certificado
const CertificadoConfig = () => import("@/views/certificado-config/index");

//Roles
const Roles = () => import("@/views/roles/Roles");
const Role = () => import("@/views/roles/Role");
const EditRole = () => import("@/views/roles/EditRole");
const CreateRole = () => import("@/views/roles/CreateRole");

Vue.use(Router);

let router = new Router({
  mode: "hash", // https://router.vuejs.org/api/#mode
  linkActiveClass: "active",
  scrollBehavior: () => ({ y: 0 }),
  routes: configRoutes(),
});

router.beforeEach((to, from, next) => {
  let roles = localStorage.getItem("roles");
  if (roles != null) {
    roles = roles.split(",");
  }
  if (to.matched.some((record) => record.meta.requiresAdmin)) {
    if (roles != null && roles.indexOf("admin") >= 0) {
      next();
    } else {
      next({
        path: "/login",
        params: { nextUrl: to.fullPath },
      });
    }
  } else if (to.matched.some((record) => record.meta.requiresUser)) {
    if (roles != null && roles.indexOf("user") >= 0) {
      next();
    } else {
      next({
        path: "/login",
        params: { nextUrl: to.fullPath },
      });
    }
  } else {
    next();
  }
});

export default router;

function configRoutes() {
  return [
    {
      path: "/index",
      component: Index,
      alias: "/",
    },
    {
      path: "/",
      redirect: "/dashboard",
      name: "Home",
      component: TheContainer,
      children: [
        {
          path: "dashboard",
          name: "Dashboard",
          component: Dashboard,
        },
        {
          path: "users",
          meta: { label: "Users" },
          component: {
            render(c) {
              return c("router-view");
            },
          },
          children: [
            {
              path: "",
              component: Users,
              meta: {
                requiresAdmin: true,
              },
            },
            {
              path: ":id",
              meta: { label: "User Details" },
              name: "User",
              component: User,
              meta: {
                requiresAdmin: true,
              },
            },
            {
              path: ":id/edit",
              meta: { label: "Edit User" },
              name: "Edit User",
              component: EditUser,
              meta: {
                requiresAdmin: true,
              },
            },
            {
              path: ":id/courses",
              meta: { label: "Cursos de usuario" },
              name: "User Courses",
              component: UserCourses,
              meta: {
                requiresAdmin: true,
              },
            },
            {
              path: "/settings",
              name: "settings",
              component: UserAjustes,
            },
          ],
        },
        //Ruta de cursos
        {
          path: "cursos",
          meta: { label: "cursos" },
          component: {
            render(c) {
              return c("router-view");
            },
          },
          children: [
            {
              path: "",
              component: cursos,
            },
          ],
        },
        //Ruta de Mis Cursos
        {
          path: "mis-cursos",
          meta: { label: "Mis Cursos" },
          component: {
            render(c) {
              return c("router-view");
            },
          },
          children: [
            {
              path: "",
              component: MisCursos,
            },
          ],
        },
        {
          path: "certificado",
          name: "certificado",
          meta: { label: "Configuración de certificado" },
          component: {
            render(c) {
              return c("router-view");
            },
          },
          children: [
            {
              path: "",
              component: CertificadoConfig,
            },
          ],
        },
        //Ruta de Products
        // {
        //   path: "products",
        //   meta: { label: "products" },
        //   component: {
        //     render(c) {
        //       return c("router-view");
        //     },
        //   },
        //   children: [
        //     {
        //       path: "",
        //       component: products,
        //     },
        //   ],
        // },
        //RUTA PARA CREAR USUARIOS DESDE EL DASHBOARD
        {
          path: "registro",
          meta: { label: "registro" },
          component: {
            render(c) {
              return c("router-view");
            },
          },
          children: [
            {
              path: "",
              component: registro,
              meta: {
                requiresAdmin: true,
              },
            },
          ],
        },
        {
          path: "roles",
          meta: { label: "Roles" },
          component: {
            render(c) {
              return c("router-view");
            },
          },
          children: [
            {
              path: "",
              component: Roles,
              meta: {
                requiresAdmin: true,
              },
            },
            {
              path: "create",
              meta: { label: "Create Role" },
              name: "Create Role",
              component: CreateRole,
              meta: {
                requiresAdmin: true,
              },
            },
            {
              path: ":id",
              meta: { label: "Role Details" },
              name: "Role",
              component: Role,
              meta: {
                requiresAdmin: true,
              },
            },
            {
              path: ":id/edit",
              meta: { label: "Edit Role" },
              name: "Edit Role",
              component: EditRole,
              meta: {
                requiresAdmin: true,
              },
            },
          ],
        },
      ],
    },
    {
      path: "/pages",
      redirect: "/pages/404",
      name: "Pages",
      component: {
        render(c) {
          return c("router-view");
        },
      },
      children: [
        {
          path: "404",
          name: "Page404",
          component: Page404,
        },
        {
          path: "500",
          name: "Page500",
          component: Page500,
        },
      ],
    },
    {
      path: "/login",
      name: "Auth",
      component: Login,
    },
    {
      path: "/coursesingle/:id",
      name: "singleCourse",
      component: detailcoruse,
    },
    {
      path: "/register",
      name: "Register",
      component: Register,
    },
    {
      path: "*",
      name: "404",
      component: Page404,
    },
  ];
}
