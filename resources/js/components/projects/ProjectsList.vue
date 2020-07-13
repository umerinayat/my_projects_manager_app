<template>
   <div>
        <ul class="projects-list">
            <li  v-for="project in projects" :key="'p-'+project.id">
                {{project.project_name}}
            </li>
        </ul>
   </div>
</template>

<script>



export default {
    components: {
        
    },
    created() {
        this.getProjects();

        Fire.$on('onProjectCreated', () => {
            this.getProjects();
        });

        Fire.$on('onProjectDeleted', () => {
            this.getProjects();
        });
    },
    data() {
        return {
            baseUrl: '/api/',
            projects: [],
        };
    },
    methods: {
        getProjects() {
            this.$Progress.start();
            axios.get(this.baseUrl + 'project')
            .then(({data})=>{
                if(data.success) {
                    this.$Progress.finish();
                    this.projects = data.projects;
                }
            });
        },
    },
}
</script>

<style scoped>

.projects-list {

    overflow: auto;
    margin: 0;
    padding: 0;
    color:white;
    font-size: 17px;
    list-style: none;
}

.projects-list li {
    padding: 10px 10px 10px 30px;
}
.projects-list li:hover {
  color:#D2D4DA !important;
  cursor: pointer;
}



</style>
