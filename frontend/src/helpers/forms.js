async function createFieldElement(field) {
  const formElement = { ...typesDefaultElements[field.type_element] };

  for (const key in field) {
    if (Object.hasOwnProperty.call(field, key)) {
      const value = field[key];

      formElement[key] = value;
    }
  }
  return formElement;
}

async function createFields(fields) {
  const fieldPromises = fields.map((field) => createFieldElement(field));
  const fieldsData = await Promise.all(fieldPromises);

  return fieldsData;
}

const defaultTextElement = {
  id: "text_id",
  name: "text_name",
  label: "text_label",
  type_element: "text",
  show: true,
  show_attribute: "",
  cols_desktop: "md:basis-1/4",
  cols_mobile: "basis-full",
  class: "",
  required: true,
  disabled: false,
  can_add: false,
  can_edit: true,
  default_value: null,
};

const defaultTextAreaElement = {
  type_element: "textarea",
  id: "textarea_id",
  name: "textarea_name",
  label: "textarea_label",
  cols_desktop: "md:basis-1/4",
  cols_mobile: "basis-full",
  class: "",
  show: true,
  show_attribute: "",
  required: true,
  disabled: false,
  can_add: false,
  can_edit: true,
  default_value: null,
};

const defaultNumberElement = {
  type_element: "number",
  id: "number_id",
  name: "number_name",
  label: "number_label",
  cols_desktop: "md:basis-1/4",
  cols_mobile: "basis-full",
  class: "",
  show: true,
  show_attribute: "",
  required: true,
  disabled: false,
  can_add: false,
  can_edit: true,
  default_value: null,
};

const defaultDateElement = {
  type_element: "date",
  id: "date_id",
  name: "date_name",
  label: "date_label",
  cols_desktop: "md:basis-1/4",
  cols_mobile: "basis-full",
  class: "",
  show: true,
  show_attribute: "",
  required: true,
  disabled: false,
  can_add: false,
  can_edit: true,
  default_value: null,
  restrict_past_dates: false,
};

const defaultTimeElement = {
  type_element: "time",
  id: "time_id",
  name: "time_name",
  label: "time_label",
  cols_desktop: "md:basis-1/4",
  cols_mobile: "basis-full",
  class: "",
  show: true,
  show_attribute: "",
  required: true,
  disabled: false,
  can_add: false,
  can_edit: true,
  default_value: null,
};

const typesDefaultElements = {
  text: defaultTextElement,
  textarea: defaultTextAreaElement,
  number: defaultNumberElement,
  date: defaultDateElement,
  time: defaultTimeElement,
};

export default {
  createFields,
  createFieldElement,
};
