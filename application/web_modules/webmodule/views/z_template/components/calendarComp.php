<div class="card ">
    <div class="card-body">
        <div class="row">
            <div id="calendar"></div>
        </div>
    </div>
</div>

<div id="editCalendarEventModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">ข้อมูลกิจกรรม</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>

<!-- Modal Add Category -->
<div class="modal fade none-border" id="add-new-event">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">เพิ่มข้อมูลกิจกรรม</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <form role="form">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form-label">ชื่อกิจกรรม</label>
                            <input class="form-control form-white" type="text" name="category-name" />
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success waves-effect waves-light save-category text-white" data-bs-dismiss="modal">เพิ่มข้อมูล</button>
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">ย้อนกลับ</button>
                </div>
            </div>
        </div>
    </div>
</div>