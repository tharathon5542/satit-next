    <!-- load pre loader component -->
    <?php $this->load->view('z_template/components/preloaderComp'); ?>

    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">

        <!-- load pre loader component -->
        <?php $this->load->view('z_template/components/topbarComp'); ?>

        <!-- load pre loader component -->
        <?php $this->load->view('z_template/components/leftbarComp'); ?>

        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">

                <!-- load bread crumb component -->
                <?php $this->load->view('z_template/components/breadCrumbComp', isset($page) ? $page : ''); ?>

                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-info">
                                <div class="d-flex no-block align-items-center">
                                    <h4 class="m-b-0 text-white">ตารางข้อมูลบุคลากร</h4>
                                    <button class="btn btn-success text-white ms-auto" onclick="openAddModal()"><i class="fas fa-plus"></i> เพิ่มข้อมูล</button>
                                </div>
                            </div>
                            <div class="card-body animated bounceInUp">
                                <div class="table-responsive">
                                    <table id="personnelTable" class="table table-striped border color-table muted-table">
                                        <thead>
                                            <tr>
                                                <th class="col-7 tablet desktop text-center">ชื่อ - นามสกุล</th>
                                                <th class="col-2 desktop">เบอร์โทร</th>
                                                <th class="col-2 desktop">อีเมล</th>
                                                <th class="col-1 desktop" style="min-width: 180px;">เครื่องมือ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- load foot component -->
        <?php $this->load->view('z_template/components/footComp'); ?>
    </div>

    <!-- modal container -->
    <div id="modal-container"></div>

    <script>
        let personnelFileFieldCount = 0;

        window.onload = function() {
            // ==========================================================
            showLoadingSweetalert();
            getPersonnel();
            // ==========================================================
        };

        function getPersonnel() {
            var personnelTable = $('#personnelTable').DataTable({
                pageLength: 25,
                responsive: {
                    breakpoints: [{
                            name: 'desktop',
                            width: Infinity
                        },
                        {
                            name: 'tablet',
                            width: 1024
                        }
                    ]
                },
                deferRender: false,
                ordering: false,
                ajax: {
                    url: "<?php echo base_url('crud/personnel/getPersonnel')  ?>",
                    type: 'GET',
                    success: function(response) {
                        personnelTable.clear().rows.add(response.data).draw();
                        Swal.close();
                    },
                    error: function(xhr, status, error) {
                        showErrorSweetalert('ผิดพลาด!', error, 1500);
                    }
                },
                columns: [{
                        data: 'personnelName'
                    }, {
                        className: 'text-center',
                        data: 'personnelTel'
                    }, {
                        className: 'text-center',
                        data: 'personnelEmail'
                    },
                    {
                        searchable: false,
                        className: 'text-center',
                        data: null,
                        render: function(data, type, row, meta) {
                            var out_put = `
                            <button type="button" class="btn btn-info me-1 text-white" onclick="openEditModal('${row.personnelID}')"><i class="far fa-edit"></i> แก้ไข</button>
                            <button type="button" class="btn btn-danger me-1 text-white" onclick="onDelete('${row.personnelID}')"><i class="fas fa-trash"></i> ลบ</button>
                            `;
                            return out_put;
                        }
                    }
                ],
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/th.json"
                }
            });
        }

        function openEditModal(id) {
            // Load modal content using AJAX
            $.ajax({
                url: "<?php echo base_url('crud/personnel/editModal/') ?>" + id,
                type: 'POST',
                dataType: "json",
                success: function(response) {

                    if (!response.status) {
                        showErrorSweetalert("ผิดพลาด!", response.errorMessage);
                        return;
                    }
                    // Insert modal content into the page
                    $("#modal-container").html(response.data);

                    // set data to form field
                    $('input[name="personnelID"]').val(response.queryData['personnelID']);
                    $('#majorID').val(response.queryData['personnelMajorID']);
                    $('#courseID').val(response.queryData['personnelCourseSet']).change();
                    $('#personnelCitizenID').val(response.queryData['personnelCitizenID']);
                    $('#personnelType').val(response.queryData['personnelTypeID']);
                    $('#personnelName').val(response.queryData['personnelName']);
                    $('#personnelSurname').val(response.queryData['personnelSurname']);
                    $('#personnelTel').val(response.queryData['personnelTel']);
                    $('#personnelPosition').val(response.queryData['personnelPosition']);
                    $('#personnelEmail').val(response.queryData['personnelEmail']);
                    $('#personnelEXP').val(response.queryData['personnelEXP']);

                    // Show the modal
                    $("#personnelEditModal").modal("show");

                    // loop personnel training file
                    $.each(response.queryData['personnelTrainingFiles'], function(index, value) {
                        setPersonnelFile(0, value.trainingID, value.trainingFileID, value.trainingDate, value.trainingFile + value.trainingFileType);
                    });

                    // loop personnel training file
                    $.each(response.queryData['personnelTrophyFiles'], function(index, value) {
                        setPersonnelFile(1, value.trophyID, value.trophyFileID, value.trophyDate, value.trophyFile + value.trophyFileType);
                    });


                },
                error: function(xhr, status, error) {
                    showErrorSweetalert('ผิดพลาด!', error, 1500);
                }
            });
        }

        function openAddModal() {
            // Load modal content using AJAX
            $.ajax({
                url: "<?php echo base_url('crud/personnel/addModal') ?>",
                dataType: "json",
                success: function(response) {
                    if (!response.status) {
                        showErrorSweetalert("ผิดพลาด!", response.errorMessage);
                        return;
                    }
                    // Insert modal content into the page
                    $("#modal-container").html(response.data);
                    // Show the modal
                    $("#personnelAddModal").modal("show");
                },
                error: function(xhr, status, error) {
                    showErrorSweetalert('ผิดพลาด!', error, 1500);
                }
            });
        }

        function onDelete(personnelID) {
            // Display a SweetAlert confirmation dialog
            Swal.fire({
                title: 'แจ้งเตือน',
                text: 'ยืนยันการลบข้อมูลบุคลากร?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'ยืนยันการลบ',
                cancelButtonText: 'ย้อนกลับ',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: '<?php echo base_url('crud/personnel/onDeletePersonnel/') ?>' + personnelID,
                        type: "POST",
                        dataType: "json",
                        success: function(response) {
                            if (!response.status) {
                                showErrorSweetalert("ผิดพลาด!", response.errorMessage);
                                return;
                            }
                            showSuccessSweetalert("สำเร็จ!", "ลบข้อมูลบุคลากรแล้ว", 1500);
                            setTimeout(function() {
                                $('#personnelTable').DataTable().ajax.reload();
                            }, 1500)
                        },
                        error: function(xhr, status, error) {
                            showErrorSweetalert('ผิดพลาด!', error, 1500);
                        }
                    });
                }
            })
        }
    </script>