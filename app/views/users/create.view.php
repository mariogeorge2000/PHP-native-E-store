<form autocomplete="off" class="appForm clearfix" method="post" enctype="application/x-www-form-urlencoded">
    <fieldset>
        <legend><?= $text_legend ?></legend>

        <div class="input_wrapper n20 border">
            <label<?= $this->labelFloat('first_name') ?>><?= $text_label_FirstName ?></label>
            <input required type="text" name="first_name" maxlength="10" value="<?= $this->showValue('first_name') ?>">
        </div>
        <div class="input_wrapper n20 border padding">
            <label<?= $this->labelFloat('last_name') ?>><?= $text_label_LastName ?></label>
            <input required type="text" name="last_name" maxlength="10" value="<?= $this->showValue('last_name') ?>">
        </div>

        <div class="input_wrapper n20 border">
            <label <?=$this->labelFloat('Username') ?> > <?= $text_label_Username ?></label>
            <input required type="text" name="Username" maxlength="30" value="<?=$this->showValue('Username')?>">
        </div>
        <div class="input_wrapper n20 border padding">
            <label <?=$this->labelFloat('Password') ?> ><?= $text_label_Password ?></label>
            <input required type="password" name="Password" value="<?=$this->showValue('Password')?>" >
        </div>
        <div class="input_wrapper n20 border padding">
            <label <?=$this->labelFloat('CPassword') ?>><?= $text_label_CPassword ?></label>
            <input required type="password" name="CPassword" value="<?=$this->showValue('CPassword')?>" >
        </div>
        <div class="input_wrapper n20 border">
            <label <?=$this->labelFloat('Email') ?> ><?= $text_label_Email ?></label>
            <input required type="email" name="Email" value="<?=$this->showValue('Email')?>" >
        </div>
        <div class="input_wrapper n20 border">
            <label <?=$this->labelFloat('CEmail') ?> ><?= $text_label_CEmail ?></label>
            <input required type="email" name="CEmail" value="<?=$this->showValue('CEmail')?>" >
        </div>
        <div class="input_wrapper n20 padding">
            <label <?=$this->labelFloat('PhoneNumber') ?> ><?= $text_label_PhoneNumber ?></label>
            <input required type="text" name="PhoneNumber" maxlength="30" value="<?=$this->showValue('PhoneNumber')?>" >
        </div>
        <div class="input_wrapper_other padding n20 select" >
            <select required name="group_id" >
                <option value=""><?= $text_user_group_id ?></option>
                <?php if (false !== $groups): foreach ($groups as $group): ?>
                    <option value="<?= $group->group_id ?>" > <?= $group->group_name ?></option>
                <?php endforeach;endif; ?>
            </select>
        </div>

        <input class="no_float" type="submit" name="submit" value="<?= $text_label_save ?>">
    </fieldset>
</form>