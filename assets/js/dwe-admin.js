( function ( wp ) {
    const { useState, useMemo, useRef } = wp.element;
    const apiFetch = wp.apiFetch;

    const data = window.devllowineSettingsData || { fields: [], values: {} };

    const groupFields = (fields) => {
        const sections = [];
        let current = { title: 'General', id: 'general', items: [] };
        fields.forEach((field) => {
            if (field.type === 'heading') {
                if (current && current.items.length) {
                    sections.push(current);
                }
                current = {
                    title: field.title || 'Section',
                    id: field.title ? field.title.toLowerCase().replace(/[^a-z0-9]+/g, '-') : 'section',
                    items: [],
                };
            } else {
                current.items.push(field);
            }
        });
        if (current && current.items.length) {
            sections.push(current);
        }
        return sections;
    };

    function Toggle({ id, value, onChange }) {
        return wp.element.createElement(
            'label',
            { className: 'dwe-toggle' },
            wp.element.createElement('input', {
                type: 'checkbox',
                checked: value === 'yes',
                onChange: (e) => onChange(id, e.target.checked ? 'yes' : 'no'),
            }),
            wp.element.createElement('span', { className: 'dwe-toggle-slider' })
        );
    }

    function FieldControl({ field, value, onChange }) {
        if (field.type === 'checkbox') {
            return wp.element.createElement(Toggle, { id: field.id, value, onChange });
        }
        if (field.type === 'single_select_page' || field.type === 'select') {
            return wp.element.createElement(
                'select',
                {
                    className: 'dwe-select',
                    value: value === undefined || value === null ? '' : value,
                    onChange: (e) => onChange(field.id, e.target.value),
                },
                Object.keys(field.options || {}).map((key) =>
                    wp.element.createElement('option', { key, value: key }, field.options[key])
                )
            );
        }
        return wp.element.createElement('input', {
            type: 'text',
            className: 'dwe-text',
            value: value || '',
            onChange: (e) => onChange(field.id, e.target.value),
        });
    }

    function SettingsApp() {
        const sections = useMemo(() => groupFields(data.fields), [data.fields]);
        const [active, setActive] = useState(sections[0] ? sections[0].id : '');
        const [values, setValues] = useState(data.values || {});
        const [saving, setSaving] = useState(false);
        const [notice, setNotice] = useState('');

        const handleChange = (id, val) => {
            const next = { ...values, [id]: val };
            setValues(next);
            doSave(true, next);
        };

        const doSave = (autoSave = false, currentValues = null) => {
            const payload = currentValues || values;

            if (!autoSave) {
                setSaving(true);
                setNotice('');
            }
            const body = new window.FormData();
            body.append('action', 'devllowine_save_settings');
            body.append('nonce', data.nonce);
            Object.keys(payload).forEach((key) => body.append(`settings[${key}]`, payload[key]));

            apiFetch({ url: data.ajaxUrl, method: 'POST', body })
                .then((resp) => {
                    if (!autoSave) {
                        setNotice(resp?.data?.message || 'Saved');
                    }
                })
                .catch(() => {
                    setNotice('Error saving settings.');
                })
                .finally(() => {
                    if (!autoSave) {
                        setSaving(false);
                    }
                });
        };

        return wp.element.createElement(
            'div',
            { className: 'dwe-settings-wrapper' },
            wp.element.createElement(
                'div',
                { className: 'dwe-settings-nav' },
                wp.element.createElement(
                    'ul',
                    null,
                    sections.map((section) =>
                        wp.element.createElement(
                            'li',
                            {
                                key: section.id,
                                className: active === section.id ? 'active' : '',
                            },
                            wp.element.createElement(
                                'a',
                                {
                                    href: '#',
                                    onClick: (e) => {
                                        e.preventDefault();
                                        setActive(section.id);
                                    },
                                },
                                section.title
                            )
                        )
                    )
                )
            ),
            wp.element.createElement(
                'div',
                { className: 'dwe-settings-content' },
                notice && wp.element.createElement('div', { className: 'notice notice-success' }, notice),
                sections.map((section) =>
                    wp.element.createElement(
                        'div',
                        { key: section.id, className: 'dwe-card', style: { display: active === section.id ? 'block' : 'none' } },
                        wp.element.createElement('h2', null, section.title),
                        section.items.map((field) =>
                            wp.element.createElement(
                                'div',
                                { key: field.id, className: 'dwe-row' },
                                wp.element.createElement('label', { htmlFor: field.id }, field.title),
                                wp.element.createElement(
                                    'div',
                                    { className: 'dwe-control' },
                                    wp.element.createElement(FieldControl, {
                                        field,
                                        value: values[field.id],
                                        onChange: handleChange,
                                    }),
                                    field.desc && wp.element.createElement('p', { className: 'description' }, field.desc)
                                )
                            )
                        )
                    )
                ),
                wp.element.createElement(
                    'div',
                    { className: 'dwe-actions' },
                    wp.element.createElement(
                        'button',
                        { type: 'button', className: 'dwe-save-btn', onClick: doSave, disabled: saving },
                        saving ? 'Saving…' : 'Save Settings'
                    )
                )
            )
        );
    }

    wp.element.render(wp.element.createElement(SettingsApp), document.getElementById('dwe-settings-root'));
})(window.wp);
