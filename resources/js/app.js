import "./bootstrap";

import confettiModule from "canvas-confetti";

import Alpine from "alpinejs";
import focus from "@alpinejs/focus";

Alpine.plugin(focus);
window.Alpine = Alpine;

window.confetti = confettiModule;

Alpine.start();
