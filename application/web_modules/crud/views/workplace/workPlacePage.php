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
                                    <h4 class="m-b-0 text-white">ตารางข้อมูลเครือข่าย CWIE </h4>
                                    <button class="btn btn-success text-white ms-auto" onclick="openAddModal()"><i class="fas fa-plus"></i> เพิ่มข้อมูล</button>
                                </div>
                            </div>
                            <div class="card-body animated bounceInUp">
                                <div class="table-responsive">
                                    <table id="workplaceTable" class="table table-striped border color-table muted-table">
                                        <thead>
                                            <tr>
                                                <th class="col-4 tablet desktop">ชื่อเครือข่าย CWIE </th>
                                                <th class="col-3 desktop">ประเทศ</th>
                                                <th class="col-3 desktop" style="min-width: 130px;">สถานะ</th>
                                                <th class="col-2 desktop" style="min-width: 140px;">เครื่องมือ</th>
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
        let workplaceMouFieldCount = 0;

        window.onload = function() {
            // ==========================================================
            showLoadingSweetalert();
            getWorkPlace();
            // ==========================================================
        };

        function getWorkPlace() {
            var workplaceTable = $('#workplaceTable').DataTable({
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
                ajax: {
                    url: "<?php echo base_url('crud/workPlace/getWorkPlace')  ?>",
                    type: 'GET',
                    success: function(response) {
                        workplaceTable.clear().rows.add(response.data).draw();
                        Swal.close();
                    },
                    error: function(xhr, status, error) {
                        showErrorSweetalert('ผิดพลาด!', error, 1500);
                    }
                },
                columns: [{
                        data: 'workPlaceName',
                        className: 'text-center'
                    },
                    {
                        data: 'workPlaceCountry',
                        className: 'text-center'
                    },
                    {
                        className: 'text-center',
                        render: function(data, type, row, meta) {
                            if (row.workPlaceStatus === 'รอการตรวจสอบ') {
                                return '<span class="text-white bg-warning p-1 rounded">' + row.workPlaceStatus + '</span>';
                            } else {
                                return '<span class="text-white bg-success p-1 rounded">' + row.workPlaceStatus + '</span>';;
                            }
                        }
                    }, {
                        searchable: false,
                        className: 'text-center',
                        render: function(data, type, row, meta) {
                            var out_put = `
                                <button  type="button" class="btn btn-info me-1 text-white" onclick="openEditModal('${row.workPlaceID}')"><i class="far fa-edit"></i> แก้ไข</button>
                                <button type="button" class="btn btn-danger me-1 text-white" onclick="onDelete('${row.workPlaceID}')"><i class="fas fa-trash"></i> ลบ</button>
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
                url: "<?php echo base_url('crud/workplace/editModal/') ?>" + id,
                type: 'POST',
                dataType: "json",
                success: function(response) {

                    if (!response.status) {
                        showErrorSweetalert("ผิดพลาด!", response.errorMessage);
                        return;
                    }
                    // Insert modal content into the page
                    $("#modal-container").html(response.data);

                    // set element value
                    // section 1
                    $('#majorID').val(response.queryData['majorID'])
                    $('#workplaceID').val(response.queryData['workplaceID'])
                    $('#courseID').val(response.queryData['workplaceCourseSet']).change();
                    $('#workplaceStatus').val(response.queryData['workplaceStatus'])
                    $('#workplaceName').val(response.queryData['workplaceName']);
                    $('#workplaceWorkType').val(response.queryData['workplaceWorkType']);
                    $('#workplaceType').val(response.queryData['workplaceType']);
                    $('#workplaceTel').val(response.queryData['workplaceTel']);
                    $('#workplaceEmail').val(response.queryData['workplaceEmail']);
                    $('#workplaceWorkType').val(response.queryData['workplaceWorkType']);
                    // section 2
                    $('#workplaceAddress').val(response.queryData['workplaceAddress']);

                    if (response.queryData['workplaceZipcode'] != null) {
                        $('#workplaceZipCode').append(new Option(response.queryData['workplaceZipcode'], response.queryData['workplaceZipcode'], false, false)).trigger('change');
                    }
                    if (response.queryData['workplaceSubDistrict'] != null) {
                        $('#workplaceSubDistrict').append(new Option(response.queryData['workplaceSubDistrict'], response.queryData['workplaceSubDistrict'], false, false)).trigger('change');
                    }
                    if (response.queryData['workplaceDistrict'] != null) {
                        $('#workplaceDistrict').append(new Option(response.queryData['workplaceDistrict'], response.queryData['workplaceDistrict'], false, false)).trigger('change');
                    }
                    if (response.queryData['workplaceProvince'] != null) {
                        $('#workplaceProvince').append(new Option(response.queryData['workplaceProvince'], response.queryData['workplaceProvince'], false, false)).trigger('change');
                    }
                    if (response.queryData['workplaceCountry'] != null) {
                        $('#workplaceCountry').append(new Option(response.queryData['workplaceCountry'], response.queryData['workplaceCountry'], false, false)).trigger('change');
                    }

                    $('#workplaceLat').val(response.queryData['workplaceLat']);
                    $('#workplaceLong').val(response.queryData['workplaceLong']);

                    // loop mou file
                    $.each(response.queryData['wokrplaceMouFiles'], function(index, value) {
                        setWorkplaceMouField(value.mouID, value.mouDetail, value.mouFileName + value.mouFileType);
                    });

                    // Show the modal
                    $("#workplaceEditModal").modal("show");
                },
                error: function(xhr, status, error) {
                    showErrorSweetalert('ผิดพลาด!', error, 1500);
                }
            });
        }

        function openAddModal() {
            // Load modal content using AJAX
            $.ajax({
                url: "<?php echo base_url('crud/workplace/addModal') ?>",
                dataType: "json",
                success: function(response) {
                    if (!response.status) {
                        showErrorSweetalert("ผิดพลาด!", response.errorMessage);
                        return;
                    }
                    // Insert modal content into the page
                    $("#modal-container").html(response.data);
                    // Show the modal
                    $("#workplaceAddModal").modal("show");
                },
                error: function(xhr, status, error) {
                    showErrorSweetalert('ผิดพลาด!', error, 1500);
                }
            });
        }

        function onDelete(workPlaceID) {
            // Display a SweetAlert confirmation dialog
            Swal.fire({
                title: 'แจ้งเตือน',
                text: 'ยืนยันการลบ?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'ยืนยันการลบ',
                cancelButtonText: 'ย้อนกลับ',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: '<?php echo base_url('crud/workplace/onDeleteworkPlace/') ?>' + workPlaceID,
                        type: "POST",
                        dataType: "json",
                        success: function(response) {
                            if (!response.status) {
                                showErrorSweetalert("ผิดพลาด!", response.errorMessage);
                                return;
                            }
                            showSuccessSweetalert("สำเร็จ!", "ลบข้อมูลเครือข่าย CWIE แล้ว", 1500);
                            setTimeout(function() {
                                $('#workplaceTable').DataTable().ajax.reload();
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