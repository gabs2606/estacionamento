
(function () {
  window.formatCurrency = function (value) {
    return Number(value).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
  };

  document.addEventListener('DOMContentLoaded', function () {
    const params = new URLSearchParams(window.location.search);
    if (params.get('sucesso') === '1') {
      if (window.Swal) {
        Swal.fire({
          icon: 'success',
          title: 'Registrado',
          text: 'Operação concluída com sucesso.',
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 2200
        });
      }
    }
  });
})();
