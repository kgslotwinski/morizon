import { startStimulusApp } from "@symfony/stimulus-bridge";
import { registerVueControllerComponents } from '@symfony/ux-vue';

startStimulusApp();
registerVueControllerComponents(require.context('./vue/controllers', true, /\.vue$/));