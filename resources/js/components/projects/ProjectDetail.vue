<template>
    <div>
        
        <div class="container-fluid p-4">
            <div class="row">
                <div class="col-sm-12">
                    <h3>Projects</h3>
                    <hr>
                    <table class="table table-bordered c-table">
                        <thead>
                            <tr>
                            <th class="text-center client-name" scope="col" colspan="3"> {{ client.name }} </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(project, index) in projects" :key="'pp-'+index">
                            <td class="project-name "> Project {{index + 1 + " - " + project.project_name }}
                               &nbsp;&nbsp; <span class="badge badge-secondary">{{project.label}}</span>    
                            </td>
                            <td class="text-center"><i class="fas fa-play"></i></td>
                            <td class="text-center">
                                 <button data-toggle="modal" data-target="#new-project-modal" @click="startUpdateClient(project)" class="btn btn-sm new-client-btn">Edit</button>
                                 <button @click="startCopyProject(project)" data-toggle="modal" data-target="#new-project-modal" class="btn btn-sm new-client-btn">Copy</button>
                                 <button @click="startMovingProject(project)" data-toggle="modal" data-target="#new-project-modal" class="btn btn-sm new-client-btn">Move</button>
                                 <button @click="startDeleteProject(project)" data-toggle="modal" data-target="#dialog" class="btn btn-sm new-client-btn">Delete</button>
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

        Fire.$on('onProjectDeleted', () => {
            this.getClientsProjects();
        });

    },
    data() {
        return {
            baseUrl: '/api/',
            currentRouteName: "",
            clientProjects: {},
            projects: [],
            client: {},
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

    startDeleteProject(project) {
        Fire.$emit('onStartDeleteProject', _.cloneDeep(project));
    },

    startMovingProject(project) {
        Fire.$emit('onStartMovingProject', _.cloneDeep(project));
    }



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

.fa-play {
    font-size: 30px;
    color:#3D4650;
    
}

.fa-play:hover{
    cursor: pointer;
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
