import app from "@/main.js";

export class HttpError extends Error {
  constructor(message, statusCode) {
    super(message);
    this.status = statusCode;
  }
}

export function showErrorMessage(error) {
  if (error instanceof HttpError) {
    console.log(`Error: ${error.message} - Status: ${error.status}`);
    app.config.globalProperties.$swal({
      icon: "error",
      title: `Error ${error.status}`,
      text: error.message,
      showConfirmButton: true,
    });
  } else {
    console.log(`Error: ${error.message}`);
    app.config.globalProperties.$swal({
      icon: "error",
      title: "Error",
      text: error.message,
    });
  }
}
