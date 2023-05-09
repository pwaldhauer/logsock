import './bootstrap';


import Alpine from 'alpinejs'

import WebPush from './components/web-push'
import Passkeys from "./components/passkeys";

window.Alpine = Alpine


Alpine.data('webPush', WebPush)
Alpine.data('passKeys', Passkeys)

Alpine.start()

