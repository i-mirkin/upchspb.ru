<?
$DB->Query("DELETE FROM b_event_type WHERE EVENT_NAME IN ('IR_NEW_USER', 'IR_FEEDBACK_FORM', 'IR_CHANGE_STATUS', 'IR_ADD_ANSWER', 'QUESTION_FORM', 'ANSWER_FORM')");
$DB->Query("DELETE FROM b_event_message WHERE EVENT_NAME IN ('IR_NEW_USER', 'IR_FEEDBACK_FORM', 'IR_CHANGE_STATUS', 'IR_ADD_ANSWER', 'QUESTION_FORM', 'ANSWER_FORM')");
?>
