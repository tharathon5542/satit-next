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
                                    <h4 class="m-b-0 text-white">ตารางข้อมูลพี่เลี้ยงเครือข่าย CWIE </h4>
                                    <button class="btn btn-success text-white ms-auto" onclick="openAddModal()"><i class="fas fa-plus"></i> เพิ่มข้อมูล</button>
                                </div>
                            </div>
                            <div class="card-body animated bounceInUp">
                                <div class="table-responsive">
                                    <table id="wpMentorTable" class="table table-striped border color-table muted-table">
                                        <thead>
                                            <tr>
                                                <th class="col-5 tablet desktop text-center">รายชื่อพี่เลี้ยง</th>
                                                <?php if ($this->session->userdata('crudSessionData')['crudPermission'] == 'admin') { ?>
                                                    <th class="col-md-5 desktop">เครือข่าย CWIE </th>
                                                <?php } ?>
                                                <th class="col-4 tablet desktop">ตำแหน่ง</th>
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
        window.onload = function() {
            // ==========================================================
            showLoadingSweetalert();
            getWpMentor();
            // ==========================================================
        };

        function getWpMentor() {
            var wpMentorTable = $('#wpMentorTable').DataTable({
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
                    url: "<?php echo base_url('crud/wpmentor/getWpMentor')  ?>",
                    type: 'GET',
                    success: function(response) {
                        wpMentorTable.clear().rows.add(response.data).draw();
                        Swal.close();
                    },
                    error: function(xhr, status, error) {
                        showErrorSweetalert('ผิดพลาด!', error, 1500);
                    }
                },
                columns: [{
                        data: 'mentorName'
                    },
                    <?php if ($this->session->userdata('crudSessionData')['crudPermission'] == 'admin') { ?> {
                            data: 'workplaceName'
                        },
                    <?php } ?> {
                        data: 'mentorPosition'
                    }, {
                        searchable: false,
                        className: 'text-center',
                        data: null,
                        render: function(data, type, row, meta) {
                            var out_put = `
                            <button type="button" class="btn btn-info me-1 text-white" onclick="openEditModal('${row.mentorID}')"><i class="far fa-edit"></i></button>
                            <button type="button" class="btn btn-danger me-1 text-white" onclick="onDelete('${row.mentorID}')"><i class="fas fa-trash"></i></button>
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
                url: "<?php echo base_url('crud/WpMentor/editModal/') ?>" + id,
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
                    $('input[name="mentorID"]').val(response.queryData['mentorID']);
                    if (response.queryData['workplaceID']) {
                        $('#workplaceID').val(response.queryData['workplaceID']);
                    }
                    $('#courseID').val(response.queryData['courseID']);
                    $('#mentorName').val(response.queryData['mentorName']);
                    $('#mentorSurname').val(response.queryData['mentorSurname']);
                    $('#mentorTel').val(response.queryData['mentorTel']);
                    $('#mentorEmail').val(response.queryData['mentorEmail']);
                    $('#mentorPostion').val(response.queryData['mentorPosition']);

                    // Show the modal
                    $("#wpMentorEditModal").modal("show");

                },
                error: function(xhr, status, error) {
                    showErrorSweetalert('ผิดพลาด!', error, 1500);
                }
            });
        }

        function openAddModal() {
            // Load modal content using AJAX
            $.ajax({
                url: "<?php echo base_url('crud/wpmentor/addModal') ?>",
                dataType: "json",
                success: function(response) {
                    if (!response.status) {
                        showErrorSweetalert("ผิดพลาด!", response.errorMessage);
                        return;
                    }
                    // Insert modal content into the page
                    $("#modal-container").html(response.data);
                    // Show the modal
                    $("#wpMentorAddModal").modal("show");
                },
                error: function(xhr, status, error) {
                    showErrorSweetalert('ผิดพลาด!', error, 1500);
                }
            });
        }

        function onDelete(mentorID) {
            // Display a SweetAlert confirmation dialog
            Swal.fire({
                title: 'แจ้งเตือน',
                text: 'ยืนยันการลบข้อมูลผู้ประสานงาน?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'ยืนยันการลบ',
                cancelButtonText: 'ย้อนกลับ',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: '<?php echo base_url('crud/wpmentor/onDeleteWpMentor/') ?>' + mentorID,
                        type: "POST",
                        dataType: "json",
                        success: function(response) {
                            if (!response.status) {
                                showErrorSweetalert("ผิดพลาด!", response.errorMessage);
                                return;
                            }
                            showSuccessSweetalert("สำเร็จ!", "ลบข้อมูลพี่เลี้ยงแล้ว", 1500);
                            setTimeout(function() {
                                $('#wpMentorTable').DataTable().ajax.reload();
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