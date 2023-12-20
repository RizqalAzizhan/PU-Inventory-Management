        <!-- Begin Page Content -->
        <div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1> 


<div class="row">
    <div class="col-lg-6">
        <?= form_error('role', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
        

        <?= $this->session->flashdata('message'); ?>

        <?php if ( $this->session->flashdata('flash') ) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
       Role has been successfuly  <?= $this->session->flashdata('flash');?>
        </div>
        <?php endif ;?>
                            
    <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newRoleModal">Add New Role</a>

    <table class="table table-hover table-bordered border-2 border-dark">
        <thead>
            <tr>
            <th scope="col">No</th>
            <th scope="col">Role</th>
            <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            <?php foreach ( $role as $r ) : ?>
            <tr>
            <th scope="row"><?= $i++; ?></th>
            <td><?=  $r['role']; ?></td>
            <td>
                <a href="<?= base_url('admin/roleaccess/'). $r['id']; ?>" class="badge bg-primary p-2 text-light text-decoration-none" >access </a> |
                <a href="" class="badge bg-success p-2 text-light text-decoration-none" >edit </a> |
                <a href="<?= base_url('admin/hapus/') ?><?= $r['id']; ?>" class="badge bg-danger p-2 text-light text-decoration-none" onclick="return confirm('yakin?');">delete</a>
            </td>
            </tr>
            <?php endforeach ; ?>
        </tbody>
    </table>
    </div>
</div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->


<!-- Modal -->
<div class="modal fade" id="newRoleModal" tabindex="-1" aria-labelledby="newRoleModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="newRoleModalLabel">Add New Role</h5>
<button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
</div>
<form action="<?= base_url('admin/role'); ?>" method="post">
<div class="modal-body">
<div class="mb-3">
<input type="text" class="form-control" id="role" name="role" placeholder="Role name">
</div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
<button type="submit" class="btn btn-primary">Add</button>
</div>
</form>
</div>
</div>
</div>
