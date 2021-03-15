// const CACHE = 'network-or-cache';
//
// self.addEventListener('install', function(evt) {
//     evt.waitUntil(preCache());
// });
//
// function preCache() {
//     return caches.open(CACHE)
//         .then(function(cache) {
//             cache.addAll([
//                 './index.html',
//                 './', // Alias for index.html,
//                 './css/style.css'
//                 // ...
//                 // TODO add all file you want to CACHE HERE
//             ]);
//         })
// }
//
// self.addEventListener('fetch', function(evt) {
//     evt.respondWith(
//         fromNetwork(evt.request, 40000)
//             .catch(function(){
//                 return fromCache(evt.request);
//             })
//     );
// });
//
//
// function fromNetwork(request, timeout) {
//     return new Promise(function (fulfill, reject) {
//         let timeoutID = setTimeout(reject, timeout);
//
//         fetch(request).then(function(response) {
//             clearTimeout(timeoutID);
//             fulfill(response);
//         }, reject);
//
//     });
// }
//
// function fromCache(request) {
//     return caches.open(CACHE)
//         .then(function(cache) {
//             return cache.match(request)
//                 .then(function (matching) {
//                     return matching || Promise.reject('no match');
//                 });
//         });
// }

console.log('dddd');
importScripts('https://unpkg.com/workbox-sw@0.0.2/build/importScripts/workbox-sw.dev.v0.0.2.js');
importScripts('https://unpkg.com/workbox-runtime-caching@1.3.0/build/importScripts/workbox-runtime-caching.prod.v1.3.0.js');
importScripts('https://unpkg.com/workbox-routing@1.3.0/build/importScripts/workbox-routing.prod.v1.3.0.js');

const assetRoute = new workbox.routing.RegExpRoute({
    regExp: new RegExp('/*'),
    handler: new workbox.runtimeCaching.CacheFirst()
});

const router = new workbox.routing.Router();
router.registerRoutes({routes: [assetRoute]});
router.setDefaultHandler({
    handler: new workbox.runtimeCaching.CacheFirst()
});
