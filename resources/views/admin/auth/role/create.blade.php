 <!-- Add Role Modal -->
 <div class="modal" id="addRoleModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addRoleForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="RoleName">Role Name :</label>
                        <input type="text" class="form-control" id="roleName" name="name" style="width: 970px">
                        <div class="error-message text-danger"></div>
                    </div>

                    <div class="form-group">
                        <div class="form-check form-check-inline">
                            <label> <input class="form-check-input mt-1" type="checkbox" id="select-all-roles"
                                    name="module_permissions[]">Permission :</label>
                        </div></br>

                        @foreach ($dashboard_module as $module)
                            <div class="d-flex align-items-center">
                                <div class="form-check form-check-inline" style="width: 140px">
                                    <label> <input class="form-check-input mt-1" type="checkbox"
                                            name="module_permissions[]" value="{{ $module }}"> Dashboard
                                        :</label><br>
                                </div>
                                <div class="mb-2 d-flex justify-content-between">
                                    @foreach ($dashboard_name as $name)
                                        <div class="form-check form-check-inline " style="width: 200px">
                                            <input class="form-check-input mt-1" type="checkbox"
                                                name="module_permissions[]" value="{{ $name }}"
                                                id="{{ $module . '_' . $name }}">
                                            <label class="form-check-label"
                                                for="{{ $module . '_' . $name }}">{{ $name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                        @foreach ($attendance_module as $module)
                            <div class="d-flex align-items-center">
                                <div class="form-check form-check-inline" style="width: 140px">
                                    <label> <input class="form-check-input mt-1" type="checkbox"
                                            name="module_permissions[]" value="{{ $module }}">Attendance
                                        :</label><br>
                                </div>
                                <div class="mb-2 d-flex justify-content-between">
                                    @foreach ($attendance_name as $name)
                                        <div class="form-check form-check-inline" style="width: 200px">
                                            <input class="form-check-input mt-1" type="checkbox"
                                                name="module_permissions[]" value="{{ $name }}"
                                                id="{{ $module . '_' . $name }}">
                                            <label class="form-check-label"
                                                for="{{ $module . '_' . $name }}">{{ $name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                        @foreach ($leave_module as $module)
                            <div class="d-flex align-items-center">
                                <div class="form-check form-check-inline" style="width: 140px">
                                    <label> <input class="form-check-input mt-1" type="checkbox"
                                            name="module_permissions[]" value="{{ $module }}">Leave :</label>
                                </div>
                                <div class="mb-2 d-flex justify-content-between">
                                    @foreach ($leave_name as $name)
                                        <div class="form-check form-check-inline" style="width: 200px">
                                            <input class="form-check-input mt-1" type="checkbox"
                                                name="module_permissions[]" value="{{ $name }}"
                                                id="{{ $module . '_' . $name }}">
                                            <label class="form-check-label"
                                                for="{{ $module . '_' . $name }}">{{ $name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                        @foreach ($department_module as $module)
                            <div class="d-flex align-items-center">
                                <div class="form-check form-check-inline" style="width: 140px">
                                    <label> <input class="form-check-input mt-1" type="checkbox"
                                            name="module_permissions[]" value="{{ $module }}">Department
                                        :</label><br>
                                </div>
                                <div class="mb-2 d-flex justify-content-between">
                                    @foreach ($department_name as $name)
                                        <div class="form-check form-check-inline" style="width: 200px">
                                            <input class="form-check-input mt-1" type="checkbox"
                                                name="module_permissions[]" value="{{ $name }}"
                                                id="{{ $module . '_' . $name }}">
                                            <label class="form-check-label"
                                                for="{{ $module . '_' . $name }}">{{ $name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                        @foreach ($employee_module as $module)
                            <div class="d-flex align-items-center">
                                <div class="form-check form-check-inline" style="width: 140px">
                                    <label> <input class="form-check-input mt-1" type="checkbox"
                                            name="module_permissions[]" value="{{ $module }}">Employee
                                        :</label><br>
                                </div>
                                <div class="mb-2 d-flex justify-content-between">
                                    @foreach ($employee_name as $name)
                                        <div class="form-check form-check-inline" style="width: 200px">
                                            <input class="form-check-input mt-1" type="checkbox"
                                                name="module_permissions[]" value="{{ $name }}"
                                                id="{{ $module . '_' . $name }}">
                                            <label class="form-check-label"
                                                for="{{ $module . '_' . $name }}">{{ $name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                        @foreach ($marksheet_module as $module)
                            <div class="d-flex align-items-center">
                                <div class="form-check form-check-inline" style="width: 140px">
                                    <label> <input class="form-check-input mt-1" type="checkbox"
                                            name="module_permissions[]" value="{{ $module }}">Marksheet
                                        :</label><br>
                                </div>
                                <div class="mb-2 d-flex justify-content-between">
                                    @foreach ($marksheet_name as $name)
                                        <div class="form-check form-check-inline" style="width: 200px">
                                            <input class="form-check-input mt-1" type="checkbox"
                                                name="module_permissions[]" value="{{ $name }}"
                                                id="{{ $module . '_' . $name }}">
                                            <label class="form-check-label"
                                                for="{{ $module . '_' . $name }}">{{ $name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                        @foreach ($role_module as $module)
                            <div class="d-flex align-items-center">
                                <div class="form-check form-check-inline" style="width: 140px">
                                    <label> <input class="form-check-input mt-1" type="checkbox"
                                            name="module_permissions[]" value="{{ $module }}">Role
                                        :</label><br>
                                </div>
                                <div class="mb-2 d-flex justify-content-between">
                                    @foreach ($role_name as $name)
                                        <div class="form-check form-check-inline" style="width: 200px">
                                            <input class="form-check-input mt-1" type="checkbox"
                                                name="module_permissions[]" value="{{ $name}}"
                                                id="{{ $module . '_' . $name }}">
                                            <label class="form-check-label"
                                                for="{{ $module . '_' . $name }}">{{ $name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                        @foreach ($adminuser_module as $module)
                            <div class="d-flex align-items-center">
                                <div class="form-check form-check-inline" style="width: 140px">
                                    <label> <input class="form-check-input mt-1" type="checkbox"
                                            name="module_permissions[]" value="{{ $module }}">AdminUser
                                        :</label><br>
                                </div>
                                <div class="mb-2 d-flex justify-content-between">
                                    @foreach ($adminuser_name as $name)
                                        <div class="form-check form-check-inline" style="width: 200px">
                                            <input class="form-check-input mt-1" type="checkbox"
                                                name="module_permissions[]" value="{{ $name }}"
                                                id="{{ $module . '_' . $name }}">
                                            <label class="form-check-label"
                                                for="{{ $module . '_' . $name }}">{{ $name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="closed"
                        data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="saveRoleData">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
