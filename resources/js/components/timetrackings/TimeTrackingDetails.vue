<template>
    <div>
        <div class="container-fluid p-4">
            <div class="row">
                <div class="col-sm-12">
                    <h3>Projects Time Tracking</h3>
                    <hr>
                    <table class="table table-bordered c-table">
                        <thead>
                            <tr>
                            <th class="text-center client-name" scope="col" colspan="4"> {{ client.name }} </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(project, index) in projects" :key="'pp-'+index">
                            <td class="project-name "> Project {{index + 1 + " - " + project.project_name }}
                               
                            </td>
                            <td class="text-center timeLabel">
                                 
                                {{ project.projectTimeTracking.total_time_spent == null ? '00 : 00 : 00' : project.projectTimeTracking.total_time_spent}}
                                 
                             </td>
                            <td class="text-center">
                                <i v-show="project.projectTimeTracking.is_time_started == 0" @click="checkTimeStatus(project.projectTimeTracking)" class="fas fa-play"></i>
                                <i v-show="project.projectTimeTracking.is_time_started == 1" @click="checkTimeStatus(project.projectTimeTracking)" class="fas fa-pause"></i>
                            </td>
                            <td class="text-center">
                                 
                                <button @click="startEditingTime(project)" data-toggle="modal" data-target="#edit-time-modal" class="btn btn-sm new-client-btn">Edit Time</button>
                            </td>
                            
                            </tr>
                            
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    props: ['id'],
    watch: {
        '$route.params.id': function (id) {
           this.getClientsProjects();
        }
      },
    created() {
        this.getClientsProjects();

        Fire.$on('onProjectUpdated', () => {
            this.getClientsProjects();
        });

        Fire.$on('onProjectCreated', () => {
            this.getClientsProjects();
        });
    },
    beforeDestroy() {
        //    if(this.updateTimeIntervalHandle !== null) {
        //        clearInterval(this.updateTimeIntervalHandle);
        //        this.updateTimeIntervalHandle = null;
        //    }         
    },
    data() {
        return {
            baseUrl: '/api/',
            currentRouteName: "",
            clientProjects: {},
            projects: [],
            client: {},
            isUpdateMode: false,
            cTimeTrack: {
                timeState: 'pause',
                totalTimeSpent: new moment(),
                formatedTimeLabel: new moment().format('MMMM Do YYYY, h:mm:ss a')
            },
            updateTimeIntervalHandle: null,
            timeIntervalsHandlers: [],
            
        };
    },
    methods: {
        getCurrentRouteName() {
            this.currentRouteName = this.$router.currentRoute.name;
        },
        getClientsProjects() {
            this.$Progress.start();
            axios.get(this.baseUrl + 'project/getClientProjects/' + this.id)
            .then(({data})=>{
                if(data.success) {

                    this.clientProjects = data.clientProjects;
                    this.projects = data.clientProjects.projects;
                    this.client = data.clientProjects.client;

                    this.$Progress.finish();
                }
            });
        }, 

    startUpdateClient(project) {
        Fire.$emit('onStartUpdateProject', _.cloneDeep(project));
    },

    startCopyProject(project) {
          Fire.$emit('onStartCopyProject', _.cloneDeep(project));
    },

    startMovingProject(project) {
        Fire.$emit('onStartMovingProject', _.cloneDeep(project));
    },

    startEditingTime(project) {
           project.client = _.cloneDeep(this.client);
           Fire.$emit('onStartEditingTime',  _.cloneDeep(project));

    },
    
   
    updateCurrentTime() {
        
         this.timeIntervalsHandlers.forEach( time => {
            if(time.tt.is_time_started) {
                time.time_spent.add(1, 'second');
                time.tt.total_time_spent = time.time_spent.format('YYYY-MM-DD HH:mm:ss');
            } else {

            }
        });
    },
    startUpdateCurrentTime(total_time, tt) {

        var keepTrackTime = {
            time_spent:  moment(total_time),
            tt: tt,
            intervalHandle: null
        };

        this.timeIntervalsHandlers.push(keepTrackTime);

        if(this.timeIntervalsHandlers.length <= 1) {
            keepTrackTime.intervalHandle = setInterval(this.updateCurrentTime, 1000);
        }
        

        



        //setInterval(this.)

    },
    checkTimeStatus(timeTracking) {


            this.$Progress.start();
            axios.get(this.baseUrl + 'timeTracking/checkTimeStatus/' + timeTracking.id)
            .then(({data})=>{
                if(data.success) {

                var tt = data.timeTracking;
              

                if(!tt.is_time_started) {
                    timeTracking.is_time_started = 1;

                    if(tt.start_time == null) {
                        console.log('tt is null');    
                        var currentDataTime = moment().format("YYYY-MM-DD HH:mm:ss");
                        var endTime = moment().add(7, 'days');
                        endTime = endTime.format("YYYY-MM-DD HH:mm:ss");
                        console.log(currentDataTime);
                        console.log(endTime);

                         timeTracking.start_time = currentDataTime; 
                         timeTracking.total_time_spent = currentDataTime;
                         timeTracking.end_time = endTime;
                         axios.post(this.baseUrl + 'timeTracking/updateTimeStatus', timeTracking)
                            .then((data)=> {
                                if(data.success) { 
                                    this.startUpdateCurrentTime(tt.total_time_spent, timeTracking);
                                }
                        });
                    } else {
                        this.startUpdateCurrentTime(tt.total_time_spent, timeTracking);
                    }

                    axios.post(this.baseUrl + 'timeTracking/updateTimeStatus', timeTracking)
                    .then((data)=> {
                        if(data.success) { 
                            
                        }
                    });

                } else {
                    timeTracking.is_time_started = 0;
                     axios.post(this.baseUrl + 'timeTracking/updateTimeStatus', timeTracking)
                    .then((data)=> {
                        if(data.success) { 
                            // stop the time here
                        }
                    });
                } 

                this.$Progress.finish();
                }
            });

        // if(this.cTimeTrack.timeState === "pause") {
        //     this.cTimeTrack.timeState = "started";
        //     this.updateCurrentTime();
        // } else {
        //       this.cTimeTrack.timeState = "pause";
        //        this.updateCurrentTime();
        // }
    },



    },

}
</script>

<style scoped>

.c-table {
    background: white;
}



.c-table
.client-name{
    font-size: 34px;
    font-weight: bold;
    color: #3D4650;
}

.project-name{
    font-weight: bold;
     font-size: 17px;
}

.badge-secondary {
    color: #fff;
    background-color: #9399A6;
}

.fa-play,.fa-pause {
    font-size: 30px;
    color: #3D4650;
    
}

.fa-play:hover{
    cursor: pointer;
}

.timeLabel {
    font-size: 20px;
}

.new-client-btn {
    
    color: white;
    background: #3D4650;
    border-color: #9399A6;
}

.new-client-btn:hover {
   background: #3E4652;
}


</style>
