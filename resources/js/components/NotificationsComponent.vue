<template>
    <section>
        <div class="page-title">
            <span class="title">Notificações</span>
            <div class="description">
                Listagem das Notificações
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <div class="title">Notificações</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="text-left col-sm-3"><input type="text" v-model="match" class="form-control" placeholder="Pesquisar"></div>
                            <div class="text-right col-sm-3 col-sm-offset-2">
                                <select class="form-control" v-model="select_notification" @change="notifications = allNotitifications[select_notification + 'notifications']">
                                    <option v-bind:value="''">Todas</option>
                                    <option v-bind:value="'expireds_'">Expiradas</option>
                                    <option v-bind:value="'lowqtd_'">Baixa no estoque</option>
                                </select>  
                            </div>
                            <div class="text-right col-sm-4">
                                <button type="button" class="btn btn-primary" @click="notifications = allNotitifications[select_notification + 'notifications']">
                                    Todas
                                </button>
                                <button type="button" class="btn btn-success" @click="notifications = allNotitifications[select_notification + 'active_notifications']">
                                    Visualizado
                                </button>
                                <button type="button" class="btn btn-info" @click="notifications = allNotitifications[select_notification + 'inactive_notifications']">
                                    Não Visualizado
                                </button>
                            </div>
                        </div>
                        <table class="table table-striped" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Conteúdo</th>
                                    <th>Estado</th>
                                    <th>Data</th>
                                    <th>Acção</th>
                                </tr>
                            </thead>
                            <transition-group enter-active-class="animated fadeInUp" leave-active-class="animated fadeOutDown" tag="tbody" mode="out-in">
                                <tr v-for="notification in notificationsFiltered" :key="notification.id">
                                        
                                    <td>{{ notification.id }}</td>
                                    <td>{{ notification.content }}</td>
                                    <td>{{ notification.status ? 'Visualizado' : 'Não visualizado' }}</td>
                                    <td>{{ notification.created_at }}</td>
                                    <td class="text-right">
                                        <a v-if="!notification.status" class="btn btn-sm btn-success" href="" @click.prevent="update(notification.id)">Marcar Como visualizado</a>
                                        <a class="btn btn-sm btn-danger" href="" @click.prevent="destroy(notification.id)" >Apagar</a>
                                    </td>
                                </tr>                                
                            </transition-group>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        mounted() {
            this.get();
        },

        data() {
            return {
                show: true,
                match: "",
                select_notification: '',
                notifications: [],
                allNotitifications: [],
            };
        },

        methods: {
            get() {
                axios
                    .get("../api/notifications")
                    .then(response => {
                        this.allNotitifications = response.data
                        this.notifications = response.data.notifications
                    })
                    .catch(error => console.log(error));
            },

            destroy(id) {
                
                swal("", "Tem certeza que deseja apagar esta Notificação?", "warning", {buttons: true, dangerMode: true}).then(result => {
                    if(result)
                        axios
                            .delete("../api/notification/destroy/" + id)
                            .then(response => {
                                if (response.data.success) {
                                    this.get();
                                    setTimeout(_ => swal("", "Notificação apagado com sucesso!", "success"), 2000);
                                }
                            })
                            .catch(error => console.log(error));
                })
            },

            update(id) {
                axios
                    .put("../api/notification/update/" + id)
                    .then(response => {
                        if (response.data.success) {
                            this.get();
                            swal("", "Notificação visualizada!", "success");
                            return true;
                        }
                        swal("", "Erro ao visualizar a notificação!", "error");
                    })
                    .catch(error => console.log(error));
            },

        },

        computed: {
            notificationsFiltered() {
                return this.notifications.filter(notification => {
                    return (
                        notification.content.toLowerCase().includes(this.match) 
                    );
                });
            }
        }
    };
</script>

<style>
    .btn{ margin-top: 0;}
</style>