<?php
file_put_contents('d:/t.log', print_r($model, true), 8);
?>
  <div id="header"><b><?php  echo empty($model['type'])?"":$model['type']; ?><b></div>
  <div id="info_content">
    <div id="title_zone">
      <p id="title"><?php echo empty($model['title'])?"":$model['title']; ?></p>
      <p id="time"><?php echo empty($model['source'])?"":$model['source']; ?>：<?php echo empty($model['addtime'])?"":$model['addtime']; ?></p>
    </div>
    <div id="msg_content">
      <p><?php echo empty($model['content'])?"":$model['content']; ?></p>
    </div>
  </div>
