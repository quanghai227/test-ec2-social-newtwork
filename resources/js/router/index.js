import Router from 'vue-router'
import Vue from 'vue'
import Home from '../pages/home/layouts/Home.vue'
import NotFound from '../pages/home/layouts/Notfound'
import Default from '../pages/home/layouts/Default'
import ListPost from '@/pages/home/post/ListPost';
import Register from '@/pages/home/auth/Register';
import Login from '@/pages/home/auth/Login';

import TestChart from '@/pages/home/chart/TestChart';
import ChatApp from '@/pages/home/messenger/ChatMain';
import ChatRedis from '@/pages/home/chat_room_redis/ChatLayout';

import Profile from '@/pages/home/user/Profile';
import SearchTag from '@/pages/home/user/SearchTag';

import ListFriend from '@/pages/home/flollow/ListFriend';
import RequestFriend from '@/pages/home/flollow/RequestFriend';

Vue.use(Router)

const routes = [
    {
        path: '/',
        component: Home,
        name: 'Home'
    },
    {
        path: '/profile/:id',
        component: Profile,
        name: 'Profile'
    },
    {
        path: '/friends',
        component: ListFriend,
        name: 'ListFriend'
    },
    {
        path: '/request-friends',
        component: RequestFriend,
        name: 'RequestFriend'
    },
    {
        path: '/welcome',
        component: Default,
        name: 'Default',
        meta: {
            title: 'default',
            layout: 'full-page',
        }
    },
    {
        path: '/register',
        component: Register,
        name: 'Register',
        meta: {
            title: 'Sign Up',
            layout: 'full-page',
        }
    },
    {
        path: '/login',
        component: Login,
        name: 'Login',
        meta: {
            title: 'Sign In',
            layout: 'full-page',
        }
    },
    {
        path: '/post-list',
        component: ListPost,
        name: 'ListPost',
        meta: {
            title: 'post-list',
            layout: 'full-page',
        }
    },
    {
        path: '/message',
        component: ChatApp,
        name: 'ChatApp',
        meta: {
            title: 'message',
            layout: 'full-page',
        }
    },
    {
        path: '/chat-redis',
        component: ChatRedis,
        name: 'ChatRedis',
        meta: {
            title: 'chat-redis',
            layout: 'full-page',
        }
    },
    {
        path: '/s-tag',
        component: SearchTag,
        name: 'SearchTag'
    },


    /* chart */
    {
        path: '/test-chart',
        component: TestChart,
        name: 'TestChart'
    },
    {
        path: '/404',
        component: NotFound,
        name: 'NotFound'

    },

    /* any url */
    {
        path: '*',
        component: NotFound,
        name: '500'

    },
];


const router = new Router({
    mode: 'history',
    routes,
});

router.beforeEach((to, from, next) => {
    // chuyển đến trang login nếu chưa được login
    const publicPages = ['/login', '/register', '/welcome'];
    const authRequired = !publicPages.includes(to.path);
    const loggedIn = sessionStorage.getItem('user');
    const loggedInToken = sessionStorage.getItem('token');

    if (authRequired && (!loggedIn || !loggedInToken)) {
        return next('/login');
    }

    next();
})

export default router
