<?php
function getGrade($marks, $passMarks = 40) {
    $marks = (float) $marks;
    if ($marks < $passMarks) {
        return "F";
    } elseif ($marks >= 90) {
        return "A+";
    } elseif ($marks >= 80) {
        return "A";
    } elseif ($marks >= 70) {
        return "B";
    } elseif ($marks >= 60) {
        return "C";
    } elseif ($marks >= 50) {
        return "D";
    } elseif ($marks >= $passMarks) {
        return "E";
    }
    return "F";
}
function removeZeros($number) {
    return rtrim(rtrim(number_format((float)$number, 2), '0'), '.');
}
?>

<style> 
.table-container {
    overflow-x: auto;
    margin-top: 20px;
}

.table-border, .table-border td {
    border: 1px solid black;
    border-collapse: collapse;
    padding: 5px;
}

.editable {
    background-color: #fffde7;
    cursor: pointer;
    border: 1px solid #ffd54f;
    text-align: center;
    width: 50px;
}

.editable:hover {
    background-color: #fff9c4;
}

.editable:focus {
    background-color: white;
    border: 2px solid #4361ee;
    outline: none;
}

.credit-hour-input {
    background-color: #f5f5f5;
    text-align: center;
    width: 40px;
    color: #333;
    font-weight: bold;
}

.updated {
    animation: highlight 1s ease;
}

@keyframes highlight {
    0% { background-color: rgba(76, 201, 240, 0.5); }
    100% { background-color: transparent; }
}

.td-border {
    border: 1px solid black;
    padding: 5px;
    text-align: center;
}

.non-editable {
    background-color: #f8f9fa;
    color: #495057;
    font-weight: bold;
    text-align: center;
    border: 1px solid #dee2e6;
}

.fail-row {
    background-color: #ffcccc !important;
}

.dropped-row {
    background-color: #ff9999 !important;
}

.fail-cell {
    background-color: #ffcccc !important;
}

.status-dropped {
    background-color: #ff9999 !important;
    font-weight: bold;
    color: #d32f2f;
}

.stat-number.updated {
    animation: statUpdate 1s ease;
    color: #4361ee;
    font-weight: bold;
}

@keyframes statUpdate {
    0% { 
        transform: scale(1.2);
        color: #4cc9f0;
    }
    100% { 
        transform: scale(1);
        color: inherit;
    }
}
</style>

<div class="table-container">
    <table class="table-border">
        <tr>
            <td colspan="2">&nbsp;</td>   
            <?php
                foreach($subjects as $sub){
                    echo "<td class='td-border' colspan='5'><h3>".$sub->course_name."</h3></td>";
                }
                 echo "<td class='td-border' colspan='4'><h3>Grand Status</h3></td>";
            ?>
        </tr>
        <tr>
            <td class="td-border">Name</td>
            <td class="td-border">Roll No</td> 
            <?php
                foreach($subjects as $sub) {
                    echo "
                    <td class='td-border'>Marks</td>
                    <td class='td-border'>GP</td>
                    <td class='td-border'>Ch</td>
                    <td class='td-border'>GPA</td>
                    <td class='td-border'>Grade</td>
                    ";
                }
            ?>
            <td class="td-border">CH</td>
            <td class="td-border">TGPA</td>
            <td class="td-border">CGPA</td> 
            <td class="td-border">Status</td>
        </tr>
        
        <?php 
        foreach($students as $roll_no => $studentData) {
            $student = $studentData['info'];
            $subjectsData = $studentData['subjects'];
            $rowClass = '';
            $statusClass = '';
            
            if ($studentData['status'] === 'Dropped') {
                $rowClass = 'dropped-row';
                $statusClass = 'status-dropped';
            }
            
            echo "<tr data-rollno='$roll_no' class='$rowClass'>";
            echo "<td class='td-border'>".$student->student_name."</td>";
            echo "<td class='td-border'>".$roll_no."</td>";
            
            foreach($subjects as $subject) {
                $res = $subjectsData[$subject->course_name] ?? null;
                
                if ($res) {
                    $markValue = removeZeros($res->obtained_mark);
                    $grade = getGrade($res->obtained_mark, 50);
                    $gradeClass = ($grade == 'F') ? 'fail-cell' : '';
                    
                    echo "<td class='td-border $gradeClass'>
                            <input type='number' class='editable' data-id='$res->id' data-field='obtained_mark' 
                            value='$markValue' min='0' max='100' step='0.1'>
                          </td>";
                    echo "<td class='td-border non-editable gp-display' data-id='$res->id'>".removeZeros($res->gp)."</td>";
                    echo "<td class='td-border'>
                            <span class='credit-hour-input'>".removeZeros($res->credit_hour)."</span>
                          </td>";
                    echo "<td class='td-border non-editable gpa-display' data-id='$res->id'>".removeZeros($res->gpa)."</td>";
                    echo "<td class='td-border non-editable grade-display $gradeClass' data-id='$res->id'>$grade</td>";
                } else {
                    echo "<td class='td-border'>-</td>";
                    echo "<td class='td-border'>-</td>";
                    echo "<td class='td-border'>-</td>";
                    echo "<td class='td-border'>-</td>";
                    echo "<td class='td-border'>-</td>";
                }
            }
            
            echo "<td class='td-border non-editable total-credits'>".removeZeros($studentData['total_credits'])."</td>";
            echo "<td class='td-border non-editable total-gpa'>".removeZeros($studentData['total_gpa'])."</td>";
            echo "<td class='td-border non-editable total-cgpa'>".removeZeros($studentData['cgpa'])."</td>";
            echo "<td class='td-border non-editable status $statusClass'>".$studentData['status']."</td>";
            
            echo "</tr>";
        }
        ?>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    const updateResult = debounce(function(resultId, field, value) {
        $.ajax({
            url: '/results/' + resultId,
            method: 'POST',
            data: {
                '_token': csrfToken,
                [field]: value
            },
            success: function(response) {
                if (response.success) {
                    $(`.gp-display[data-id="${resultId}"]`)
                        .text(response.gp % 1 === 0 ? response.gp.toFixed(0) : response.gp.toFixed(1))
                        .addClass('updated');
                    
                    $(`.gpa-display[data-id="${resultId}"]`)
                        .text(response.gpa % 1 === 0 ? response.gpa.toFixed(0) : response.gpa.toFixed(1))
                        .addClass('updated');
                    
                    $(`.grade-display[data-id="${resultId}"]`)
                        .text(response.grade)
                        .addClass('updated');
                    const gradeCell = $(`.grade-display[data-id="${resultId}"]`);
                    if (response.grade === 'F') {
                        gradeCell.addClass('fail-cell');
                    } else {
                        gradeCell.removeClass('fail-cell');
                    }
                    
                    setTimeout(() => {
                        $(`.gp-display[data-id="${resultId}"], 
                           .gpa-display[data-id="${resultId}"],
                           .grade-display[data-id="${resultId}"]`)
                            .removeClass('updated');
                    }, 1000);
                    updateStudentTotals(resultId, response.cgpa, response.status);
                    updateStatistics(response.stats);
                }
            },
            error: function(xhr) {
                console.error('Error updating result:', xhr.responseText);
                alert('Error updating result. Please try again.');
            }
        });
    }, 500);

    function updateStudentTotals(resultId, cgpa, status) {
        const row = $(`input[data-id="${resultId}"]`).closest('tr');
        const rollNo = row.data('rollno');
        let totalCredits = 0;
        let totalGPA = 0;
        
        row.find('.credit-hour-input').each(function() {
            totalCredits += parseFloat($(this).text()) || 0;
        });
        
        row.find('.gpa-display').each(function() {
            totalGPA += parseFloat($(this).text()) || 0;
        });
        
        const calculatedCGPA = totalCredits > 0 ? totalGPA / totalCredits : 0;
        const calculatedStatus = calculatedCGPA >= 2.1 ? 'Pass' : 'Dropped';
        
        function cleanNumber(num) {
            return num % 1 === 0 ? num.toFixed(0) : num.toFixed(2);
        }
        row.find('.total-credits').text(cleanNumber(totalCredits)).addClass('updated');
        row.find('.total-gpa').text(cleanNumber(totalGPA)).addClass('updated');
        row.find('.total-cgpa').text(cleanNumber(calculatedCGPA)).addClass('updated');
        const statusCell = row.find('.status');
        statusCell.text(calculatedStatus).addClass('updated');
        
        if (calculatedStatus === 'Dropped') {
            row.addClass('dropped-row');
            statusCell.addClass('status-dropped');
        } else {
            row.removeClass('dropped-row');
            statusCell.removeClass('status-dropped');
        }
        
        setTimeout(() => {
            row.find('.total-credits, .total-gpa, .total-cgpa, .status').removeClass('updated');
        }, 1000);
    }

    function updateStatistics(stats) {
        $('.stat-box:nth-child(1) .stat-number').text(stats.total_students).addClass('updated');
        $('.stat-box:nth-child(2) .stat-number').text(stats.fail_count).addClass('updated');
        $('.stat-box:nth-child(3) .stat-number').text(stats.less_than_3).addClass('updated');
        $('.stat-box:nth-child(4) .stat-number').text(stats.greater_than_3).addClass('updated');
        $('.stat-box:nth-child(5) .stat-number').text(stats.session_gpa.toFixed(2)).addClass('updated');
        setTimeout(() => {
            $('.stat-number').removeClass('updated');
        }, 1000);
    }

    $('.editable').on('input', function() {
        const resultId = $(this).data('id');
        const field = $(this).data('field');
        let value = $(this).val();
        
        if (field === 'obtained_mark') {
            value = Math.min(100, Math.max(0, value));
            $(this).val(value);
        }
        
        updateResult(resultId, field, value);
    });
});
</script>