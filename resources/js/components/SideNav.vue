<template>
    <div>
        <ul class="text-center side-nav">
    
    <li> 
        <div class="c-link" @mouseover="linkMouseOver" @mouseleave="linkMouseLeave">
            <span class="dot mt-3"></span>
            <div>
                <router-link  to="/timetracking"> Time Tracking  </router-link>
            </div>

            <div class="active-border">
                    
            </div>

        </div>
    </li>
    <li> 
       <div class="c-link" @mouseover="linkMouseOver" @mouseleave="linkMouseLeave">
            <span class="dot mt-3"></span>
            <div>
                <router-link  to="/projects"> Projects  </router-link>
            </div>

            <div class="active-border">
                    
            </div>

        </div>
    </li>
    <li> 
        <div class="c-link" @mouseover="linkMouseOver" @mouseleave="linkMouseLeave">
            <span class="dot mt-3"></span>
            <div>
                <router-link  to="/clients"> Clients </router-link>
            </div>

            <div class="active-border">
                    
            </div>

        </div>
         
         
    </li>


    <li> 
       <a href="#">
        <span class="dot mt-3"></span>
            <div>
                Time Reports 
            </div> 
       </a>
    </li>
    <li> 
        <a href="#">
            <span class="dot mt-3"></span>
            <div>
                Time Registeraion
            </div>
        </a>
    </li>

    <li> 
        <a href="#">
            <span class="dot mt-3"></span>
            <div>
                Notes
            </div> 
        </a>
    </li>
    
    <li> 
        <a href="#">
            <span class="dot mt-3"></span>
            <div>
                Reminders
            </div> 
        </a>
    </li>
    <li> 
       <a href="#">
            <span class="dot mt-3"></span>
            <div>
                Offers
            </div> 
       </a>
    </li>
    <li> 
        <a href="#">
            <span class="dot mt-3"></span>
            <div>
                Calender
            </div>
        </a>
    </li>
</ul>
    </div>
</template>

<script>
export default {
    methods: {
        openSidePanel() {
            this.$emit('onHitOpenSidePanel', {});
        },
        linkMouseOver() {
           ($(event.target).find('.active-border')).addClass('tBorder');
        },
        linkMouseLeave() {
           ($(event.target).find('.active-border')).removeClass('tBorder');
        }

    },
    data() {
        return {
            
        };
    }
}
</script>

<style>

.side-nav{
    height: 880px;
}

.c-link:hover  {
    color: white;
    cursor: pointer;
}

.c-link {
    position: relative;
}


.tBorder {
    height: 100%;
    width: 6px;
    background: #9399A6;
    border: 1px solid #9399A6;
    position: absolute;
    top: 0px;
    right: 0px;
   
}

</style>
