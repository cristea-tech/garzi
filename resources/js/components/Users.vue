<template>
  <div class="container">
    <div class="row mt-5">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Users Table</h3>

            <div class="card-tools">
              <div class="input-group input-group-sm" style="width: 150px;">
                <input type="text" name="table_search" class="form-control float-right" placeholder="Search"/>
                <div class="input-group-append">
                  <button type="submit" class="btn btn-default">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table id="tabel" class="table table-hover text-nowrap">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Type</th>
                  <th>Adaugat</th>
                  <th>Modify</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="user in users" :key="user.id">
                  <td>{{user.id}}</td>
                  <td>{{user.name | upText }}</td>
                  <td>{{user.email}}</td>
                  <td>{{user.tip | upText}}</td>
                  <td>{{user.created_at | myDate }}</td>
                  <td>
                    <a href="#">
                      <i class="fa fa-edit fa-fw blue"></i>
                    </a> /
                    <a href="#">
                      <i class="fa fa-trash fa-fw red"></i>
                    </a>
                  </td>
                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="4"></td>
                  <td>
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addNew">Add user <i class="fas fa-user-plus"></i></button>
                  </td>
                </tr>
              </tfoot>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>

    <div class="modal fade" id="addNew">
      <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h4 class="modal-title">Adaugare user nou</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body blue">
              <form @submit.prevent="createUser">
                <div class="card-body">
                    <div class="form-group">
                        <label>Nume:</label>
                        <input v-model="form.name" type="text" name="name" class="form-control" :class="{ 'is-invalid': form.errors.has('name') }"/>
                        <has-error :form="form" field="name"></has-error>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input v-model="form.email" type="email" name="email" class="form-control" :class="{ 'is-invalid': form.errors.has('email') }"/>
                        <has-error :form="form" field="email"></has-error>
                    </div>
                    <div class="form-group">
                        <label>Parola:</label>
                        <input v-model="form.password" type="password" name="password" class="form-control" :class="{ 'is-invalid': form.errors.has('password') }"/>
                        <has-error :form="form" field="password"></has-error>
                    </div>
                    <div class="form-group">
                        <label>Tip:</label>
                        <select name="tip" id="tip" v-model="form.tip" type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('tip') }">
                            <option value="User" selected>User</option>
                            <option value="Admin">Admin</option>
                        </select>
                        <has-error :form="form" field="tip"></has-error>
                    </div>
                    <div class="form-group">
                        <label>Descriere:</label>
                        <textarea v-model="form.descriere" rows="3" type="textarea" name="descriere" class="form-control" :class="{ 'is-invalid': form.errors.has('descriere') }"></textarea>
                        <has-error :form="form" field="descriere"></has-error>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Inchide</button>
                    <button type="submit" class="btn btn-primary btn-sm float-right">Salveaza</button>
              </div>
              </form>
          </div>
        </div>

        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
  </div>
</template>

<script>
export default {
  data() {
    return {
      users : {},
      form: new Form({
        name: "",
        email: "",
        password: "",
        tip: "",
        descriere: "",
      }),
    };
  },
  methods: {
      loadUsers(){
          axios.get("api/user").then(({ data }) => (this.users = data.data));
      },

      createUser(){
          this.$Progress.start();
          this.form.post('api/user');
          // semnalizez un eveniment AfterCreate cu metoda emit atasata la Fire
          Fire.$emit('AfterCreate');
          $('#addNew').modal('hide');
          toast.fire({
            icon: 'success',
            title: 'User created successfully.'
            });
          this.$Progress.finish();
      }
  },
  created() {
    this.loadUsers();
    // cand evenimentul AfterCreate este produs se declanseaza actualizarea paginii
    Fire.$on('AfterCreate', () => {
        this.loadUsers();
    });
    // setInterval(() => this.loadUsers(),3000);
  },
};
</script>
