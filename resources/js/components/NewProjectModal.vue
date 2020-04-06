<template>
    <modal name="new-project" classes="p-10 bg-card rounded-lg" height="auto">
        <h1 class="font-normal mb-16 text-default text-center text-2xl">Create New Project</h1>
        <form @submit.prevent="submit">
            <div class="flex">
                <div class="flex-1 mr-4">
                    <div class="mb-4">
                        <label for="title" class="text-sm mb-2 block">
                            Title <span class="text-red-400">*</span>
                        </label>
                        <input name="title" id="title"
                               class="border rounded p-2 w-full block"
                               :class="form.errors.title ? 'border-red-500' : 'border-muted-light'"
                               type="text" v-model="form.title">
                        <span class="text-red-500 text-xs italic" v-if="form.errors.title" v-text="form.errors.title[0]"></span>
                    </div>
                    <div class="mb-4">
                        <label for="description" class="text-sm mb-2 block">
                            Description <span class="text-red-400">*</span>
                        </label>
                        <textarea name="description" id="description"
                                  class="border rounded p-2 w-full block"
                                  :class="form.errors.description ? 'border-red-500' : 'border-muted-light'"
                                  type="text" rows="5" v-model="form.description">
                        </textarea>
                        <span class="text-red-500 text-xs italic" v-if="form.errors.title" v-text="form.errors.description[0]"></span>
                    </div>
                </div>

                <div class="flex-1 ml-4">
                    <div class="mb-4">
                        <label class="text-sm mb-2 block">Create Some Tasks</label>
                        <input name="task" id="tasks"
                               class="border border-muted-light rounded p-2 mb-4 w-full block"
                               type="text" placeholder="Task 1"
                               v-for="task in form.tasks" v-model="task.body">

                        <button type="button" class="inline-flex items-center text-xs" @click="addTask">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" class="mr-2">
                                <g fill="none" fill-rule="evenodd" opacity=".307">
                                    <path stroke="#000" stroke-opacity=".012" stroke-width="0" d="M-3-3h24v24H-3z"></path>
                                    <path fill="#000"
                                          d="M9 0a9 9 0 0 0-9 9c0 4.97 4.02 9 9 9A9 9 0 0 0 9 0zm0 16c-3.87 0-7-3.13-7-7s3.13-7 7-7 7 3.13 7 7-3.13 7-7 7zm1-11H8v3H5v2h3v3h2v-3h3V8h-3V5z">
                                    </path>
                                </g>
                            </svg>
                            <span>Add New Task Field</span>
                        </button>

                    </div>
                </div>
            </div>
            <footer class="flex justify-end">
                <button type="button" class="button is-outlined mr-2" @click="$modal.hide('new-project')">
                    Cancel
                </button>
                <button class="button">
                    Create
                </button>
            </footer>
        </form>

    </modal>
</template>


<script>
    import UserForm from './BirdBoardForm.js';

    export default {

        data() {
            return {
                form: new BirdBoardForm({
                    title: '',
                    description: '',
                    tasks: [
                        { body: ''},
                    ]
                })
            };
        },

        methods: {
            addTask() {
                this.form.tasks.push({ body: '' });
            },

            async submit() {
                // If no tasks ignore the body
                if(! this.form.tasks[0].body){
                    delete this.form.originalData.tasks;
                }

                this.form.submit('/projects')
                .then(response => location = response.data.message);



                // no object oriented
                // try {
                //     location = (await axios.post('/projects', this.form)).data.message;
                // } catch (error) {
                //     this.errors = error.response.data.errors;
                // }
                // Same functionality but another way:
                // submit() {
                //     axios.post('/projects', this.form)
                //         .then(response => {
                //             location = response.data.message
                //             //location.reload() to reload the page
                //         })
                //         .catch(error => {
                //             this.errors = error.response.data.errors;
                //         })
                // }
            }


        }
    }
</script>
