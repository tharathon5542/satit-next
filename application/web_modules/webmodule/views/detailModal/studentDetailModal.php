<div id="studentDetailModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="min-width: 80%;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">ข้อมูลนักศึกษา CWIE</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="row p-4">
                            <h4 class="text-center">รายชื่อนักศึกษา CWIE <?php echo !$this->session->userdata('moduleYearID') ? 'ทุกปีการศึกษา' : 'ปีการศึกษา ' . $this->db->get_where('cwie_year', array('year_id' => $this->session->userdata('moduleYearID')))->row()->year_title ?></h4>
                            <div class="table-responsive">
                                <table id="studentDataTable" class="table table-striped border color-table muted-table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="col-md-2 desktop">รหัสนักศึกษา</th>
                                            <th class="col-md-6 tablet desktop text-center">ชื่อ - สกุล</th>
                                            <th class="col-md-2 desktop">สาขา</th>
                                            <th class="col-md-2 desktop">คณะ</th>
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
</div>

<script>
    $('#studentDetailModal').on('hidden.bs.modal', function() {
        $('#modal-container').html('');
    })
</script>