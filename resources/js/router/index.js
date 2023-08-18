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
const Task = () => import('@/components/Task/Index.vue')
const CreateTask = () => import('@/components/Task/Create.vue')
const EditTask = () => import('@/components/Task/Edit.vue')
/* Authenticated Component */


const routes = [
    {
        name: "home",
        path: "/",
        component: Welcome,
        meta: {
            title: `Ellipsis Task Manager`
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
        // component: DashboardLayout,
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
                name: "tasks",
                path: '/tasks',
                component: Task,
                meta: {
                    title: `Task`
                }
            },
            {
                name: "create_task",
                path: 'create/task',
                component: CreateTask,
                meta: {
                    title: `Create Task`
                }
            },
            {
                name: "edit_task",
                path: 'edit/task:id',
                component: EditTask,
                meta: {
                    title: `Edit Task`
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
    if (to.meta.middleware == "guest") {
        if (localStorage.getItem("jwt")) {
            next({ name: "dashboard" })
        }
        next()
    } else {
        if (localStorage.getItem("jwt")) {
            next()
        } else {
            next()
        }
    }
})

export default router
