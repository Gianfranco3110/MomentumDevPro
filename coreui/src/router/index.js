import Vue from "vue";
import Router from "vue-router";

// Containers
const TheContainer = () => import("@/containers/TheContainer");

// Views
const Dashboard = () => import("@/views/Dashboard");

//Detalle del curso
const detailcoruse = () => import("@/views/pages/courseDetail");

//muestra de todos los cursos
const courseAll = () => import("@/views/pages/courseAll");

//CURSO PARA MOSTRAR AL USUARIO MODULO PAPA
const courseShow = () => import("@/views/users/course-show");

const landing = () => import("@/views/pages/Landing");


// Views - Pages
const Page404 = () => import("@/views/pages/Page404");
const Page500 = () => import("@/views/pages/Page500");
const Login = () => import("@/views/pages/Login");

const VerificSuccess = () => import("@/views/pages/VerificSuccess");

const ResetPassword = () => import("@/views/pages/ResetPassword");

const Register = () => import("@/views/pages/Register");
const Index = () => import("@/views/pages/Index");

// Users
const Users = () => import("@/views/users/Users");
const User = () => import("@/views/users/User");
const EditUser = () => import("@/views/users/EditUser");
const UserAjustes = () => import("@/views/users/UserAjustes");
const UserPerfil = () => import("@/views/users/UserPerfil");
const MisCursos = () => import("@/views/users/MisCursos");
const UserCourses = () => import("@/views/users/user-courses");
const UserCoursesTest = () => import("@/views/users/user-courses-test-validate");

//Products
const products = () => import("@/views/products/index");

//Cursos
const cursos = () => import("@/views/cursos/index");

//Cursos secciones
const cursosSection = () => import("@/views/course-section/indexViews");

//CONSTANTE PARA REGISTRAR USUARIOS DESDE EL DASHBOARD
const registro = () => import("@/views/RegistroAdmin/index");

//configuracion de certificado
const CertificadoConfig = () => import("@/views/certificado-config/index");

//actualizacion de recursos del sitio
const ActualizacionRecursos = () => import("@/views/ActualizacionRecursos/index");

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
      component: landing,
      alias: "/",
    },
    {
      path: "/curso-online",
      component: Index,
      alias: "/cursos-online",
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
              path: ":id/courses/:id_course/test-validate",
              meta: { label: "Validar Test" },
              name: "User Courses Test",
              component: UserCoursesTest,
              meta: {
                requiresAdmin: true,
              },
            },
            {
              path: "/settings",
              name: "settings",
              component: UserAjustes,
            },
            {
              path: "/perfil",
              name: "perfil",
              component: UserPerfil,
              meta: { requiresUser: true },
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
        {
          path: "cursos/secciones",
          name: "cursoseccion",
          meta: { label: "cursos secciones" },
          component: {
            render(c) {
              return c("router-view");
            },
          },
          children: [
            {
              path: "",
              component: cursosSection,
            },
          ],
        },
        //Ruta de Mis Cursos
        {
          path: "mis-cursos",
          name:"miscursos",
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
            {
              path: ":id",
              meta: { label: "Mostrar curso" },
              name: "show_course_user",
              component: courseShow
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
        {
          path: "actualizacion-recursos",
          name: "actualizacion-recursos",
          meta: { label: "Actualización de Recursos", requiresAdmin: true },
          component: {
            render(c) {
              return c("router-view");
            },
          },
          children: [
            {
              path: "",
              component: ActualizacionRecursos,
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
      path: "/reset-password/:token/:id",
      name: "ResetPassword",
      component: ResetPassword,
    },
    {
      path: "/courseall",
      name: "cursosall",
      component: courseAll,
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
      path: "/verificado",
      name: "verificado",
      component: VerificSuccess,
    },
    {
      path: "*",
      name: "404",
      component: Page404,
    },
  ];
}
