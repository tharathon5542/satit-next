<div id="workplaceMouDetailModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="min-width: 80%;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">ข้อมูลเครือข่าย MOU</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="row p-4">
                            <h4 class="text-center">รายชื่อเครือข่าย MOU <?php echo !$this->session->userdata('moduleYearID') ? 'ทุกปีการศึกษา' : 'ปีการศึกษา ' . $this->db->get_where('cwie_year', array('year_id' => $this->session->userdata('moduleYearID')))->row()->year_title ?></h4>
                            <div class="table-responsive">
                                <table id="workplaceMouDataTable" class="table table-striped border color-table muted-table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="col-6 tablet desktop text-center">ชื่อเครือข่าย</th>
                                            <th class="col-5 desktop">เรื่อง</th>
                                            <th class="col-2 desktop">เอกสาร</th>
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
    $('#workplaceMouDetailModal').on('hidden.bs.modal', function() {
        $('#modal-container').html('');
    })
</script>