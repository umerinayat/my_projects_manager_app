<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-1" style="padding:0;margin:0">
                <!-- <SideNav v-on:onHitOpenSidePanel="onHitOpenSidePanel($event)"></SideNav> -->
                <SideNav></SideNav>
            </div>
            <div class="col-sm-11">
                <router-view></router-view>
                 <vue-progress-bar></vue-progress-bar>
            </div>
        </div>
    </div>
</template>

<script>

import SideNav from './SideNav';

export default {
    components: {
        SideNav,
    },
    data() {
        return {
            //isSidePanelOpen: false
        };
    },
    methods: {
        // onHitOpenSidePanel(parms) {
        //     if(this.isSidePanelOpen) {
        //         this.isSidePanelOpen = false;
        //         return;
        //     }
        //     this.isSidePanelOpen = true;
        // }
    }
}
</script>

<style>

</style>
