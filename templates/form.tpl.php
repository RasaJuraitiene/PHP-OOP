<form
    <?php print html_attr(($form['attr'] ?? []) + ['method' => 'POST']); ?>>
    <?php foreach ($form['fields'] ?? [] as $field_id => $field): ?>
    <?php if(!isset($field['type'])) var_dump($field); ?>
        <div class="field-wrapper">
            <?php if ($field['type'] == 'select'): ?>
                <select name="<?php print $field_id; ?>">
                        <span class="label">
                            <?php print $field ['label'] ?? ''; ?>
                        </span>
                    <?php foreach ($field['option'] as $key => $optall): ?>
                        <option value="<?php print $key ?>"> <?php print $optall; ?></option>
                    <?php endforeach; ?>
                </select>
            <?php else: ?>
                <label>
                    <span><?php print $field['label'] ?? ''; ?></span>
                    <input <?php print html_attr(
                        [
                            'name' => $field_id,
                            'type' => $field['type'],
                            'value' => $field['value'] ?? '',
                        ]
                        + ($field['extra']['attr'] ?? [])) ?>>
                </label>
            <?php endif; ?>
            <?php if (isset($field['error'])): ?>
                <div>
                    <span class="field-error"><?php print $field['error']; ?></span>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>

    <?php foreach ($form['buttons'] ?? [] as $button_id => $button): ?>
        <button <?php print html_attr(['name' => 'action', 'value' => 'button_id'] + $button['extra']['attr'] ?? []); ?>>
            <?php print $button ['title']; ?>
        </button>
    <?php endforeach; ?>

    <?php if (isset($form['error'])): ?>
        <div>
            <span class="form-error"><?php print $form['error']; ?></span>
        </div>
    <?php endif; ?>
</form>
