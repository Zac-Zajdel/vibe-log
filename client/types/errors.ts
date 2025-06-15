export interface ValidationError {
  data: {
    message: string;
    errors?: Record<string, string[]>;
  };
  status?: number;
}
