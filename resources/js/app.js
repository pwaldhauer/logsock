import './bootstrap';


import Alpine from 'alpinejs'

import WebPush from './components/web-push.js'

window.Alpine = Alpine


Alpine.data('webPush', WebPush)

Alpine.start()

