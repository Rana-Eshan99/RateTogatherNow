<!-- Modal -->
<div class="modal fade" id="addDepartmentModal" tabindex="-1" role="dialog" aria-labelledby="addDepartmentModalTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title cardHeading" id="addDepartmentModalTitle">Add Department</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('user.department.add') }}" method="POST" id="addDepartmentForm">
                <div class="modal-body" style="padding-top: 0px;">
                    @csrf
                    <!-- Organization Id -->
                    <div class="form-group">
                        <input type="hidden" id="addDepartmentOrganizationId" name="organizationId"
                            readonly class="form-control inputFieldHeight customBorderRadius" value="">
                    </div>
                    <!-- Department Name -->
                    <div class="form-group mb-2">
                        <label for="department" class="labelHeading">Department</label>
                        <input type="text" class="form-control inputFieldHeight customBorderRadius"
                            name="department" id="department" placeholder="Enter department" autofocus>
                        <span class="invalid-feedback d-block addDepartmentValidationError" id="departmentError"
                            role="alert"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary customBorderRadius btnHeight"
                        data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary customBorderRadius btnHeight customBtnColor"
                        id="saveDepartmentBtn">Add Department</button>
                </div>
            </form>
        </div>
    </div>
</div>
