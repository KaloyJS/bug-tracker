<!-- Edit Modal HTML -->
<div id="updateReport-<?php echo $report->getId(); ?>" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Report</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Report Type</label>
                        <select name="reportType" class="form-control" required>
                            <option value="<?php echo $report->getReportType(); ?>"><?php echo $report->getReportType(); ?></option>
                            <option value="video player">video player</option>
                            <option value="audio">Audio</option>
                            <option value="others">others</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="<?php echo $report->getEmail(); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Message</label>
                        <textarea class="form-control" name="message" required><?php echo $report->getMessage(); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Link</label>
                        <input type="url" class="form-control" name="link" value="<?php echo $report->getLink(); ?>" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="reportId" value="<?php echo $report->getId(); ?>">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                    <input type="submit" class="btn btn-info" name="update" value="Update">
                </div>
            </form>
        </div>
    </div>
</div>