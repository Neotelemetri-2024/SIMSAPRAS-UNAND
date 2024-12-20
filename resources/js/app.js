import "./bootstrap";
import "flowbite";
import Alpine from "alpinejs";
import Chart from "chart.js/auto";
import "@fortawesome/fontawesome-free/css/all.css";

window.Chart = Chart;
window.Alpine = Alpine;

Alpine.start();
Chart.start();
