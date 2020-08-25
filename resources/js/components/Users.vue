<template>
    <div class="container">
        <div class="row mt-5">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Users Table</h3>

                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Type</th>
                      <th>Modify</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>183</td>
                      <td>John Doe</td>
                      <td>11-7-2014</td>
                      <td><span class="tag tag-success">Approved</span></td>
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
                               <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-default">
                                  Add user
                               </button>
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

      <div class="modal fade" id="modal-default">
        <div class="modal-dialog modal-sm modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header bg-primary">
              <h4 class="modal-title">Adaugare user nou</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body blue">
              <form id="new_user" action="#" method="POST">
                  @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="nume">Nume utilizator</label>
                    <input type="text" class="form-control" id="nume" placeholder="nume si prenume">
                  </div>
                  <div class="form-group">
                    <label for="email">Adresa email</label>
                    <input type="email" class="form-control" id="email" placeholder="email">
                  </div>
                  <div class="form-group">
                    <label for="parola">Parola</label>
                    <input type="password" class="form-control" id="parola" placeholder="parola">
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
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
