@extends('backend.layouts.main')
@section('title', __('List book'))
@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

      <!-- /.row -->
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
                <form>
                  <div class="form-row pull-right">
                    <div class="form-group col-md-3">
                      <span class="h3 text-uppercase">List of book</span>
                    </div>
                    <div class="form-group col-md-5">
                      <input type="text" class="form-control" id="inputCity">
                    </div>
                    <div class="form-group col-md-3">
                      <select id="inputState" class="form-control">
                        <option selected>Choose...</option>
                        <option>Author</option>
                        <option>Name</option>
                      </select>
                    </div>
                    <div class="input-group-btn">
                      <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                    </div>
                  </div>
                </form>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-striped table-hover">
                <tr>
                  <th>No.</th>
                  <th>Name</th>
                  <th>Author</th>
                  <th>Average review score</th>
                  <th>Total borrow</th>
                  <th>Option</th>
                </tr>
                <tr>
                  <td>183</td>
                  <td>John Doe</td>
                  <td>11-7-2014</td>
                  <td><span class="label label-success">Approved</span></td>
                  <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                  <td align="center">
                  <a href="#"
                  class= "btn-edit fa fa-pencil-square-o btn-custom-option pull-left-center"></a>
                  <button type="submit" class="btn-custom-option btn btn-delete-item fa fa-trash-o"></button>
                  </td>
                </tr>
                <tr>
                  <td>219</td>
                  <td>Alexander Pierce</td>
                  <td>11-7-2014</td>
                  <td><span class="label label-warning">Pending</span></td>
                  <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                  <td align="center">
                  <a href="#"
                  class= "btn-edit fa fa-pencil-square-o btn-custom-option pull-left-center"></a>
                  <button type="submit" class="btn-custom-option btn btn-delete-item fa fa-trash-o"></button>
                  </td>
                </tr>
                <tr>
                  <td>657</td>
                  <td>Bob Doe</td>
                  <td>11-7-2014</td>
                  <td><span class="label label-primary">Approved</span></td>
                  <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                  <td align="center">
                  <a href="#"
                  class= "btn-edit fa fa-pencil-square-o btn-custom-option pull-left-center"></a>
                  <button type="submit" class="btn-custom-option btn btn-delete-item fa fa-trash-o"></button>
                  </td>
                </tr>
                <tr>
                  <td>175</td>
                  <td>Mike Doe</td>
                  <td>11-7-2014</td>
                  <td><span class="label label-danger">Denied</span></td>
                  <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                  <td align="center">
                  <a href="#"
                  class= "btn-edit fa fa-pencil-square-o btn-custom-option pull-left-center"></a>
                  <button type="submit" class="btn-custom-option btn btn-delete-item fa fa-trash-o"></button>
                  </td>
                </tr>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
    </section>
    <div class="box-footer clearfix">
      <ul class="pagination pagination-sm no-margin pull-right">
        <li><a href="#">&laquo;</a></li>
        <li><a href="#">1</a></li>
        <li><a href="#">2</a></li>
        <li><a href="#">3</a></li>
        <li><a href="#">&raquo;</a></li>
      </ul>
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
