<style>
    .ui-state-default {
        cursor: pointer;
    }

    .layout-height {
        min-height: 65px;
    }

    /* .widget-list {
        max-height: 400px;
        overflow-y: scroll;
    } */

    .widget-single {
        display: inline-block;
        width: 100%;
        box-shadow: 5px 5px 10px -8px #bfbfbf;
        cursor: grab;
    }

    .section-widget {
        border-bottom: 1px solid #cbcbcd;
    }

    .widget-placeholder {
        border: 1px dotted black;
        height: auto;
        width: 100%;
        padding: 0px;
    }

    .widget-icons {
        visibility: hidden;
        transition-duration: 0.01s;
    }

    .section-widget:hover .widget-icons {
        visibility: visible;
        transition-duration: 0.01s;
    }

    .builder-sidebar .card-header i {
        transform: rotate(90deg);
        transition: 0.3s transform ease-in-out;
    }

    .builder-sidebar .card-header .collapsed i {
        transform: rotate(0deg);
    }

    #section_layout svg {
        height: 50px;
        width: 100%;
        cursor: pointer;
    }

    #section_layout svg path {
        fill: #d5dadf;
    }

    #section_layout svg path:hover {
        fill: #aaaaaa;
    }

    .img_layout {
        min-width: 115px;
        border-width: 4px;
        border-style: solid;
        border-color: #d9d9d9;
        cursor: pointer;
    }

    .bg-deactive {
        background-color: #d1d1d1 !important;
    }

    .popover_wrapper {
        position: relative;
        display: inline-block;
        margin-bottom: 13px;
    }

    .popover_content {
        opacity: 0;
        visibility: hidden;
        position: absolute;
        left: -50%;
        top: -100%;
        z-index: 999;
        transform: translate(50%, 100%);
        background-color: #eeeeee;
        box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26);
    }

    .popover_wrapper:hover .popover_content {
        z-index: 10;
        opacity: 1;
        visibility: visible;
        transform: translate(0, -20px);
        transition: all 0.5s cubic-bezier(0.75, -0.02, 0.2, 0.97);
    }
</style>
