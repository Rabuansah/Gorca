<?= $this->extend('user/layout/default'); ?>

<?= $this->section('content'); ?>
<title>User GCA | Lapangan</title>
<?= $this->endSection(); ?>


<?= $this->section('content'); ?>
<div class="content">
    <div class="container">
        <div class="row gy-5 justify-content-center mt-5 pt-4">
            <div class="col-lg-12">
                <div class="text-center">
                    <h3 class="heading">Detail Transaksi</h3>
                    <p class="text-muted">Gor Chandra Alkadrie</p>
                </div>
            </div><!-- End col -->
            <form action="<?= site_url('user/proses_pembayaran') ?>" method="post">
                <?= csrf_field() ?>
                <div class="table-responsive">
                    <table class="table table-striped custom-table">
                        <thead>
                            <tr>
                                <th scope="col"> <label class="control control--checkbox"> <input type="checkbox" class="js-check-all">
                                        <div class="control__indicator"></div>
                                    </label> </th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Nama Pemesan</th>
                                <th scope="col">Nama Lapangan</th>
                                <th scope="col">Kategori Lapangan</th>
                                <th scope="col">Jam Booking</th>
                                <th scope="col">Tarif</th>
                                <th scope="col">Status Pembayaran</th>
                                <!-- <th scope="col">Status</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($penyewaanInfo as $value) : ?>
                                <?php
                                $current_date = date('Y-m-d');
                                if ($value->tanggal_penyewaan >= $current_date) : ?>
                                    <tr scope="row" class="<?= ($value->status_pembayaran == 1) ? 'row-lunas' : ''; ?>">
                                        <td>
                                            <?php if ($value->status_pembayaran != 1) : ?>
                                                <input type="checkbox" name="selected_ids[]" class="select-checkbox js-checkbox" data-tarif="<?= $value->tarif ?>" value="<?= $value->id_penyewaan ?>">
                                            <?php endif; ?>
                                        </td>
                                        <td><?= $value->tanggal_penyewaan; ?></td>
                                        <td><?= $value->username; ?></td>
                                        <td><?= $value->nama_lapangan; ?></td>
                                        <td><?= $value->kategori; ?></td>
                                        <td><?= substr($value->start_hour, 0, 5); ?> - <?= substr($value->end_hour, 0, 5); ?></td>
                                        <td>Rp <?= number_format($value->tarif, 0, ',', '.'); ?></td>
                                        <td>
                                            <?php
                                            // Lakukan pengecekan status_pembayaran
                                            if ($value->status_pembayaran == 1) {
                                                echo 'Lunas';
                                            } else {
                                                echo 'Pending';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="text-center mt-4">
                        <p name="tarif">Total Tarif: <span id="displayTotalTarif">Rp 0</span></p>
                        <input type="hidden" name="tarif" id="hiddenTotalTarif" value="0">
                        <button class="btn btn-success btn-lg" type="submit">Bayar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    const checkboxes = document.querySelectorAll('.select-checkbox');
    s
    const displayTotalTarifElement = document.getElementById('displayTotalTarif');
    const hiddenTotalTarifElement = document.getElementById('hiddenTotalTarif');
    let totalTarif = 0;
    const selectedIdList = [];

    function formatRupiah(angka) {
        var reverse = angka.toString().split('').reverse().join(''),
            ribuan = reverse.match(/\d{1,3}/g);
        ribuan = ribuan.join('.').split('').reverse().join('');
        return 'Rp ' + ribuan;
    }

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const tarif = parseFloat(this.getAttribute('data-tarif'));
            const selectedId = parseInt(this.getAttribute('data-id'));
            if (this.checked) {
                totalTarif += tarif;
                selectedIdList.push(selectedId);
            } else {
                totalTarif -= tarif;
                const indexToRemove = selectedIdList.indexOf(selectedId);
                if (indexToRemove !== -1) {
                    selectedIdList.splice(indexToRemove, 1);
                }
            }
            displayTotalTarifElement.textContent = formatRupiah(totalTarif);
            hiddenTotalTarifElement.value = totalTarif;
            console.log(selectedId); // This will output the selected id_penyewaan
        });
    });
</script>
<?= $this->endSection(); ?>