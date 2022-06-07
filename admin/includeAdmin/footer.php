</main>
<hr>
  <footer class="">
  <div class="container-fluid">
        <p class="d-flex justify-content-center align-items-center fw-semibold">  <?= date('Y') ?> - &copy; - Khayreddine - IFOCOP - <a class="me-3" href="#">Mentions légales</a><a href="#"> Condition générales de ventes</a></p>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" 
  integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="modal.js"></script>
  <script>
          var myModal = document.getElementById('myModal');
          var myInput = document.getElementById('myInput');

          myModal.addEventListener('shown.bs.modal', function () {
          myInput.focus()
          })
  </script>
</body>
</html>