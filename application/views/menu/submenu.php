        <!-- Begin Page Content -->
        <div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1> 


<div class="row">
    <div class="col-lg">
        <?php if (validation_errors()) : ?>
        <div class="alert alert-danger" role="alert">
        <?= validation_errors() ?>
        </div>
        
        <?php endif ;?>   

        <?= $this->session->flashdata('message'); ?>

        <?php if ( $this->session->flashdata('flash') ) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
        Menu has been successfuly  <?= $this->session->flashdata('flash');?>
        </div>
        <?php endif ;?>
                            
    <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newSubMenuModal">Add New Submenu</a>

    <table class="table table-hover table-bordered border-2 border-dark">
        <thead>
            <tr>
            <th scope="col">No</th>
            <th scope="col">Sub Menu</th>
            <th scope="col">Menu</th>
            <th scope="col">Url</th>
            <th scope="col">Icon</th>
            <th scope="col">Active</th>
            <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            <?php foreach ( $subMenu as $sm ) : ?>
            <tr>
            <th scope="row"><?= $i++; ?></th>
            <td><?=  $sm['title']; ?></td>
            <td><?=  $sm['menu']; ?></td>
            <td><?=  $sm['url']; ?></td>
            <td><?=  $sm['icon']; ?></td>
            <td><?=  $sm['is_active']; ?></td>
            <td>
                <a href="" class="badge bg-success p-2 text-light" >edit </a> |
                <a href="<?= base_url('menu/hapus/') ?><?= $sm['id']; ?>" class="badge bg-danger p-2 text-light" onclick="return confirm('yakin?');">delete</a>
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
<div class="modal fade" id="newSubMenuModal" tabindex="-1" aria-labelledby="newSubMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newSubMenuModalLabel">Add New Sub Menu</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('menu/submenu'); ?>" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                    <input type="text" class="form-control" id="titles" name="title" placeholder="Submenu title">
                    </div>
                    <div class="form-group">
                        <select name="menu_id" id="menu_id" class="form-select">
                            <option value="">Select Menu</option>
                            <?php foreach ( $menu as $m ) : ?>
                                <option value="<?= $m['id']; ?>"><?= $m['menu']; ?></option>
                            <?php endforeach ; ?>

                        </select>
                    </div>
                    <div class="mb-3">
                    <input type="text" class="form-control" id="url" name="url" placeholder="Submenu url">
                    </div>
                    <div class="mb-3">
                    <input type="text" class="form-control" id="icon" name="icon" placeholder="Submenu icon">
                    </div>
                    <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" name="is_active" id="is_active" checked>
                        <label class="form-check-label" for="is_active">
                            Active?
                        </label>
                    </div>
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