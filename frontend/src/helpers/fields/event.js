const eventFields = [
  {
    type_element: "text",
    id: "title",
    name: "title",
    label: "Title",
    cols_desktop: "md:basis-2/4",
    cols_mobile: "basis-full",
  },
  {
    type_element: "textarea",
    id: "description",
    name: "description",
    label: "Description",
    cols_desktop: "md:basis-2/4",
    cols_mobile: "basis-full",
    required: true,
  },
  {
    type_element: "date",
    id: "startDate",
    name: "startDate",
    label: "Start Date",
    required: true,
  },
  {
    type_element: "date",
    id: "endDate",
    name: "endDate",
    label: "End Date",
    required: true,
  },
];

export default eventFields;
