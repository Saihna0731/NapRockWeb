import './bootstrap';

import Alpine from 'alpinejs';

import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

import markerIcon2xUrl from 'leaflet/dist/images/marker-icon-2x.png';
import markerIconUrl from 'leaflet/dist/images/marker-icon.png';
import markerShadowUrl from 'leaflet/dist/images/marker-shadow.png';

window.Alpine = Alpine;
window.L = L;

// Fix Leaflet default marker icons when bundling with Vite.
delete L.Icon.Default.prototype._getIconUrl;
L.Icon.Default.mergeOptions({
	iconRetinaUrl: markerIcon2xUrl,
	iconUrl: markerIconUrl,
	shadowUrl: markerShadowUrl,
});

Alpine.start();
