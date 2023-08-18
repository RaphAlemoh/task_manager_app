import { createWebHistory, createRouter } from 'vue-router'
// import store from '@/store'

/* Guest Component */
const Login = () => import('@/components/Login.vue')
const Register = () => import('@/components/Register.vue')
const Welcome = () => import('@/components/Welcome.vue')
/* Guest Component */

/* Authenticated Component */
const Dashboard = () => import('@/components/Dashboard.vue')
const Board = () => import('@/components/Board.vue')
const Team = () => import('@/components/Team/Index.vue')
const CreateTeam = () => import('@/components/Team/Create.vue')
const EditTeam = () => import('@/components/Team/Edit.vue')

const User = () => import('@/components/User/Index.vue')
const CreateUser = () => import('@/components/User/Create.vue')
const EditUser = () => import('@/components/User/Edit.vue')
/* Authenticated Component */


const routes = [
    {
        name: "home",
        path: "/",
        component: Welcome,
        meta: {
            title: `Ellipsis Task Manager`,
            middleware: "guest"
        }
    },
    {
        name: "login",
        path: "/login",
        component: Login,
        meta: {
            middleware: "guest",
            title: `Login`
        }
    },
    {
        name: "register",
        path: "/register",
        component: Register,
        meta: {
            middleware: "guest",
            title: `Register`
        }
    },
    {
        path: "/dashboard",
        meta: {
            middleware: "auth"
        },
        children: [
            {
                name: "dashboard",
                path: '/dashboard',
                component: Dashboard,
                meta: {
                    title: `User Dashboard`
                }
            },

            {
                name: "board",
                path: '/board',
                component: Board,
                meta: {
                    title: `Task Board`
                }
            },

            {
                name: "teams",
                path: '/teams',
                component: Team,
                meta: {
                    title: `Team`
                }
            },
            {
                name: "create_team",
                path: 'create/team',
                component: CreateTeam,
                meta: {
                    title: `Create Team`
                }
            },
            {
                name: "edit_team",
                path: 'edit/team:id',
                component: EditTeam,
                meta: {
                    title: `Edit Team`
                }
            },
            {
                name: "users",
                path: '/users',
                component: User,
                meta: {
                    title: `User`
                }
            },
            {
                name: "create_user",
                path: 'create/user',
                component: CreateUser,
                meta: {
                    title: `Create User`
                }
            },
            {
                name: "edit_user",
                path: 'edit/user:id',
                component: EditUser,
                meta: {
                    title: `Edit User`
                }
            }
        ]
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

router.beforeEach((to, from, next) => {
    document.title = to.meta.title
    if (to.meta.name == "login" || to.meta.name == "register" && localStorage.getItem("jwt")) {
        next({ name: "dashboard" })
    } else {
        next()
    }
})

export default router
