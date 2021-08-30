import {createWebHistory, createRouter} from "vue-router";

import Home from '../pages/Home';
import Register from '../pages/Register';
import Login from '../pages/Login';
import Dashboard from '../pages/Dashboard';

import Films from '../components/Films';
import AddFilm from '../components/AddFilm';
import ViewFilm from '../components/ShowFilm';

import AddComment from '../components/AddComment';

export const routes = [
    {
        name: 'home',
        path: '/',
        component: Home
    },
    {
        name: 'register',
        path: '/register',
        component: Register
    },
    {
        name: 'login',
        path: '/login',
        component: Login
    },
    {
        name: 'dashboard',
        path: '/dashboard',
        component: Dashboard
    },
    {
        name: 'films',
        path: '/films',
        component: Films
    },
    {
        name: 'addfilm',
        path: '/films/add',
        component: AddFilm
    },
    {
        name: 'viewfilm',
        path: '/films/:slug',
        component: ViewFilm
    },
    {
        name: 'addcomment',
        path: '/comments/add',
        component: AddComment
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

export default router;
