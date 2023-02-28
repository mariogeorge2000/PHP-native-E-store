<form autocomplete="off" class="appForm clearfix" method="post" enctype="application/x-www-form-urlencoded">
    <fieldset>
        <legend><?= $text_legend ?></legend>
        <div class="input_wrapper n4 0 padding" >
            <label <?=$this->labelFloat('email', $user) ?> ><?= $text_label_Email ?></label>
            <input required type="email" name="Email" value="<?=$this->showValue('email', $user)?>" >
        </div>
        <div class="input_wrapper n40 padding">
            <label <?=$this->labelFloat('phone_number', $user) ?> ><?= $text_label_PhoneNumber ?></label>
            <input required type="text" name="PhoneNumber" maxlength="30" value="<?=$this->showValue('phone_number' , $user)?>" >
        </div>
        <div class="input_wrapper_other padding n20 select" >
            <select required name="group_id" >
                <option value=""><?= $text_user_group_id ?></option>
                <?php if (false !== $groups): foreach ($groups as $group): ?>
                    <option value="<?= $group->group_id ?>"
                        <?= $this->selectedIf('group_id',$group->group_id,$user)?> >
                        <?= $group->group_name ?></option>
                <?php endforeach;endif; ?>
            </select>
        </div>

        <input class="no_float" type="submit" name="submit" value="<?= $text_label_save ?>">
    </fieldset>
</form>