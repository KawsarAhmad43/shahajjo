import { createRouter, createWebHistory } from "vue-router";

/** Define Route... */
const routes = [{
    path: '',
    component: () => import('../views/admin/layout.vue'),
    beforeEnter: checkAuth,
    children: [
        // ------------------MENU PORTION------------------
        { path: '/frontMenu', name: 'frontMenu.index', meta: { title: 'Menu', nav: true }, component: () => import('./../views/admin/website/menu/index') },
        { path: '/frontMenu/create', name: 'frontMenu.create', component: () => import('./../views/admin/website/menu/create') },
        { path: '/frontMenu/:id', name: 'frontMenu.show', component: () => import('./../views/admin/website/menu/view') },
        { path: '/frontMenu/:id/edit', name: 'frontMenu.edit', component: () => import('./../views/admin/website/menu/create') },
        // ------------------CONTENT PORTION------------------
        { path: '/content', name: 'content.index', component: () => import('./../views/admin/website/content/index') },
        // { path: '/content/create', name: 'content.create', component: () => import('./../views/admin/website/content/create') },
        { path: '/content/:slug', name: 'content.show', component: () => import('./../views/admin/website/content/view') },
        { path: '/content/:slug/edit', name: 'content.edit', component: () => import('./../views/admin/website/content/create') },
        { path: '/content-file/:slug', name: 'content.file', component: () => import('./../views/admin/website/content/createFile') },
        // ------------------SLIDER PORTION------------------
        { path: '/slider', name: 'slider.index', meta: { title: 'Slider', nav: true }, component: () => import('./../views/admin/website/gallery/slider/index') },
        { path: '/slider/create', name: 'slider.create', component: () => import('./../views/admin/website/gallery/slider/create') },
        { path: '/slider/:id', name: 'slider.show', component: () => import('./../views/admin/website/gallery/slider/view') },
        { path: '/slider/:id/edit', name: 'slider.edit', component: () => import('./../views/admin/website/gallery/slider/create') },

        // ------------------Slider Details portion------------------
        { path: '/slider-details', name: 'slider-details.index', meta: { title: 'Slider Details', nav: true }, component: () => import('./../views/admin/website/gallery/slider/details/index') },
        { path: '/slider-details/create', name: 'slider-details.create', component: () => import('./../views/admin/website/gallery/slider/details/create') },
        { path: '/slider-details/:id', name: 'slider-details.show', component: () => import('./../views/admin/website/gallery/slider/details/view') },
        { path: '/slider-details/:id/edit', name: 'slider-details.edit', component: () => import('./../views/admin/website/gallery/slider/details/create') },

        // ------------------ALBUM PORTION------------------
        { path: '/album', name: 'album.index', meta: { title: 'Album', nav: true }, component: () => import('./../views/admin/website/gallery/album/index') },
        { path: '/album/create', name: 'album.create', component: () => import('./../views/admin/website/gallery/album/create') },
        { path: '/album/:id', name: 'album.show', component: () => import('./../views/admin/website/gallery/album/view') },
        { path: '/album/:id/edit', name: 'album.edit', component: () => import('./../views/admin/website/gallery/album/create') },
        // ------------------PHOTO PORTION------------------
        { path: '/photo', name: 'photo.index', meta: { title: 'Photo', nav: true }, component: () => import('./../views/admin/website/gallery/photo/index') },
        { path: '/photo/create', name: 'photo.create', component: () => import('./../views/admin/website/gallery/photo/create') },
        { path: '/photo/:id', name: 'photo.show', component: () => import('./../views/admin/website/gallery/photo/view') },
        { path: '/photo/:id/edit', name: 'photo.edit', component: () => import('./../views/admin/website/gallery/photo/edit') },
        // ------------------VIDEO PORTION------------------
        { path: '/video', name: 'video.index', meta: { title: 'Video', nav: true }, component: () => import('./../views/admin/website/gallery/video/index') },
        { path: '/video/create', name: 'video.create', component: () => import('./../views/admin/website/gallery/video/create') },
        { path: '/video/:id', name: 'video.show', component: () => import('./../views/admin/website/gallery/video/view') },
        { path: '/video/:id/edit', name: 'video.edit', component: () => import('./../views/admin/website/gallery/video/create') },
        // ------------------News portion------------------
        { path: '/news', name: 'news.index', meta: { title: 'News', nav: true }, component: () => import('./../views/admin/website/news/index') },
        { path: '/news/create', name: 'news.create', component: () => import('./../views/admin/website/news/create') },
        { path: '/news/:id', name: 'news.show', component: () => import('./../views/admin/website/news/view') },
        { path: '/news/:id/edit', name: 'news.edit', component: () => import('./../views/admin/website/news/create') },
        // ------------------Notice portion------------------
        { path: '/notice', name: 'notice.index', meta: { title: 'Notice', nav: true }, component: () => import('./../views/admin/website/notice/index') },
        { path: '/notice/create', name: 'notice.create', component: () => import('./../views/admin/website/notice/create') },
        { path: '/notice/:id', name: 'notice.show', component: () => import('./../views/admin/website/notice/view') },
        { path: '/notice/:id/edit', name: 'notice.edit', component: () => import('./../views/admin/website/notice/create') },

        // ------------------ADMIN PORTION------------------
        { path: '/dashboard', name: 'dashboard', component: () => import('./../views/admin/dashboard.vue') },
        { path: '/admin', name: 'admin.index', component: () => import('./../views/admin/admin/index') },
        { path: '/admin/create', name: 'admin.create', component: () => import('./../views/admin/admin/create') },
        { path: '/admin/:id', name: 'admin.show', component: () => import('./../views/admin/admin/view') },
        { path: '/admin/:id/edit', name: 'admin.edit', component: () => import('./../views/admin/admin/create') },
        // ------------------ROLE PORTION------------------
        { path: '/role', name: 'role.index', component: () => import('./../views/admin/system/role/index') },
        { path: '/role/create', name: 'role.create', component: () => import('./../views/admin/system/role/create') },
        { path: '/role/:id', name: 'role.show', component: () => import('./../views/admin/system/role/view') },
        { path: '/role/:id/edit', name: 'role.edit', component: () => import('./../views/admin/system/role/create') },
        // ------------------MENU PORTION------------------
        { path: '/menu', name: 'menu.index', component: () => import('./../views/admin/system/menu/index') },
        { path: '/menu/create', name: 'menu.create', component: () => import('./../views/admin/system/menu/create') },
        { path: '/menu/:id', name: 'menu.show', component: () => import('./../views/admin/system/menu/view') },
        { path: '/menu/:id/edit', name: 'menu.edit', component: () => import('./../views/admin/system/menu/create') },
        // ------------------SITE SETTING PORTION------------------
        { path: '/siteSetting', name: 'siteSetting.index', component: () => import('./../views/admin/system/siteSettings/index') },
        { path: '/siteSetting/create', name: 'siteSetting.create', component: () => import('./../views/admin/system/siteSettings/create') },
        { path: '/siteSetting/:id', name: 'siteSetting.show', component: () => import('./../views/admin/system/siteSettings/view') },
        { path: '/siteSetting/:id/edit', name: 'siteSetting.edit', component: () => import('./../views/admin/system/siteSettings/create') },
        // ------------------MODULE PORTION------------------
        { path: '/module', name: 'module.index', component: () => import('./../views/admin/system/module/index') },
        { path: '/module/create', name: 'module.create', component: () => import('./../views/admin/system/module/create') },
        // ------------------ACTIVITY LOG PORTION------------------
        { path: '/activityLog', name: 'activityLog.index', component: () => import('./../views/admin/system/activityLog/index') },
        { path: '/activityLog/:id', name: 'activityLog.show', component: () => import('./../views/admin/system/activityLog/view') },
        { path: '/sitemap', name: 'sitemap.index', component: () => import('./../views/admin/system/sitemap/Index') },

        // ------------------FAQ PORTION------------------
        {
            path: '/faq',
            name: 'faq.index',
            component: () => import('./../views/admin/faq/index')
        }, {
            path: '/faq/create',
            name: 'faq.create',
            component: () => import('./../views/admin/faq/create')
        }, {
            path: '/faq/:id',
            name: 'faq.show',
            component: () => import('./../views/admin/faq/view')
        }, {
            path: '/faq/:id/edit',
            name: 'faq.edit',
            component: () => import('./../views/admin/faq/create')
        },

        // ------------------CONTACTS PORTION------------------
        {
            path: '/contacts',
            name: 'contacts.index',
            component: () => import('./../views/admin/contacts/index')
        }, {
            path: '/contacts/create',
            name: 'contacts.create',
            component: () => import('./../views/admin/contacts/create')
        }, {
            path: '/contacts/:id',
            name: 'contacts.show',
            component: () => import('./../views/admin/contacts/view')
        }, {
            path: '/contacts/:id/edit',
            name: 'contacts.edit',
            component: () => import('./../views/admin/contacts/create')
        },

        // ------------------EVENTS PORTION------------------
        {
            path: '/events',
            name: 'events.index',
            component: () => import('./../views/admin/events/index')
        }, {
            path: '/events/create',
            name: 'events.create',
            component: () => import('./../views/admin/events/create')
        }, {
            path: '/events/:id',
            name: 'events.show',
            component: () => import('./../views/admin/events/view')
        }, {
            path: '/events/:id/edit',
            name: 'events.edit',
            component: () => import('./../views/admin/events/create')
        },

        // ------------------CATEGORY PORTION------------------
        {
            path: '/category',
            name: 'category.index',
            component: () => import('./../views/admin/category/index')
        }, {
            path: '/category/create',
            name: 'category.create',
            component: () => import('./../views/admin/category/create')
        }, {
            path: '/category/:id',
            name: 'category.show',
            component: () => import('./../views/admin/category/view')
        }, {
            path: '/category/:id/edit',
            name: 'category.edit',
            component: () => import('./../views/admin/category/create')
        },

        // ------------------PROFILE PORTION------------------
        { path: '/profile', name: 'profile.index', component: () => import('./../views/admin/profile/index') },
        { path: '/profile/create', name: 'profile.create', component: () => import('./../views/admin/profile/create') },
        { path: '/profile/:id', name: 'profile.show', component: () => import('./../views/admin/profile/view') },
        { path: '/profile/:id/edit', name: 'profile.edit', component: () => import('./../views/admin/profile/create') },
        // ------------------PLUGIN PORTION------------------
        { path: '/plugin', name: 'plugin.index', component: () => import('./../views/admin/plugin/index') },
        { path: '/plugin/create', name: 'plugin.create', component: () => import('./../views/admin/plugin/create') },
        { path: '/plugin/:id', name: 'plugin.show', component: () => import('./../views/admin/plugin/view') },
        { path: '/plugin/:id/edit', name: 'plugin.edit', component: () => import('./../views/admin/plugin/create') },
    ],
}]

/** Check Authentication */
function checkAuth(to, from, next) {
    let role = localStorage.getItem('role')
    let user = localStorage.getItem('user')
    if (role && user) {
        next();
    } else {
        window.location.href = "/";
    }
}

/** Init Router */
const router = createRouter({
    history: createWebHistory(process.env.MIX_VUE_ROUTER_BASE),
    scrollBehavior() {
        window.scrollTo(0, 0);
    },

    linkExactActiveClass: "active",
    routes
});




export default router;
