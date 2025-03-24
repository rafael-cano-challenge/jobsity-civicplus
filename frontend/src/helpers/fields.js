import eventFields from "./fields/event";

export const getFormFields = (typeField) => {
  return [...fields[typeField]];
};

export const fields = {
  event: eventFields
};

export default {
  getFormFields,
};
