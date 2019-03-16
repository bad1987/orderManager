<?php include('templates/header.php');?>

<div class="container-fluid">
    <!-- sidebar -->
  <div class="row">
    <div class="col-sm-4 col-md-2">
      <div class="sidenav">
        <a href="#">About</a>
        <a href="#">Services</a>
        <a href="#">Clients</a>
        <a href="#">Contact</a>
      </div>
    </div>
    <!-- new pagination -->
    <div class="col-sm-8 col-md-8">
      <?php if(isset($stat)){?>
      <table class="table table-responsive">
          <thead>
              <tr>
                  <th>Commande &numero;</th>
                  <th>Date commande</th>
                  <th>Montant HT</th>
              </tr>
          </thead>
          <tbody>
              <?php foreach ($stat as $key => $value) {?>
                  <tr>
                      <td><?php echo $value['numCmde']; ?></td>
                      <td><?php echo $value['dateCmde']; ?></td>
                      <td><?php echo (float)$value['montantHT']; ?></td>
                  </tr>
              <?php } ?>
          </tbody>
      </table>
      <?php } ?>   
      <?php if(isset($pagination)){
              echo $pagination;
          }
      ?>
    </div>
  </div>
</div>

<?php include('templates/footer.php');?>