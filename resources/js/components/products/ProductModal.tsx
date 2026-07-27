
import React, { useState } from 'react'; //import react component
//import type(a keyword used to define the shape, structure, and behavior of data)
import { ProductFormData } from '../../types/ProductModal';

//in react and ts, is a keyword used to 
//a contract or bluepirnt for the structure of an object
interface ProductModalProps {
  isOpen: boolean;
  onClose: () => void;
  onSubmit: (data: ProductFormData) => void;
}

//const declares variables whose refrence or value cannot be reassigned after initialization
const initialFormState: ProductFormData = {
  brand_id: '',
  sku: '',
  erp_name: '',
  technical_name: '',
  guarantee_years: '',
  volume_liters: '',
  base_type: '',
  is_fibrated: false,
  requires_separate_primer: false,
};

export const ProductModal: React.FC<ProductModalProps> = ({ isOpen, onClose, onSubmit }) => {
    //const to restart the form data to the initial state
    const [formData, setFormData] = useState<ProductFormData>(initialFormState);
    //const to manage the loading state of the form
    const [loading, setLoading] = useState(false);
    //const to manage the error state of the form
    const [error, setError] = useState<string | null>(null);

    //if the modal isn't open, return null to not render the modal
    if (!isOpen) return null;

    //funcion named handleChange is the standar, community-accepted naming convention 
    //for a function that captures and processes user input from form elements
    // e is shorthand for event
    //React.ChangeEvent is a specific generic type provied by React, It tells TypeScript that this function handles an event where a elemnt's value chanes 
    //HTMLInputElement is a built-in browser type representing text inputs, checkboxes, and radio buttons
    const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement>) =>
    {
        //target is a property on the event that refrences the exact HTML element
        //(the specific input or select element)
        const { name, value, type } = e.target;
        const isCheckbox = type === 'checkbox';

        //prev pdeclares a parameter placeholder representing the previous, 
            //current state data safely before this update happens.
        setFormData((prev)=> ({
            ...prev,
            //evaluate the variable "name" string dynamically as the object key 
                //e.g. if name is 'email', this compiles to email
                //isCheckbox: The boolean flag variable from const... 
                // condition ? expression_if_true : expression_if_false
                // isCheckbox ? checkbox = checked : 'email'
            [name]: isCheckbox ? (e.target as HTMLInputElement).checked : value,
        }));
    };

    //handleSubmit handles the form submit
    //async mark the functions as asynchronous, this allows you to use the 
    //await keyword inside it to pause execution for networks requests 
    //without freezing the browser
        //takes one argument named e and tells typeScript that this function
        //handles the browser
    const handleSubmit = async (e: React.FormEvent) => {
        e.preventDefault();
        setLoading(true);
        setError(null);

        try {
            //const response = await
            //creates a variable 'response' to hold the network outcome
            //fetch calls the built-in browser API to send a request 
            //to that specific API path
            const response = await fetch ('/api/v1/admin/products', {
                //Configure the request as a POST method, telling the 
                //backend server
                //that i want create or save new data
                method: 'POST',
                //Provides metadata about the request
                headers :{
                    'Content-Type' : 'application/json',
                    'Accept':'application/json',
                },
                //converts a js object into a flat
                body: JSON.stringify({
                    //Unpacks all the existing value pairs from the 
                    //state object 
                    ...formData,
                    brand_id: Number(formData.brand_id),
                    guarantee_years: Number(formData.guarantee_years),
                    volume_liters: Number(formData.volume_liters),
                }),
            });
            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || 'Error creating product');
            }
            //resets the form inputs back to blank after successful database save
            setFormData(initialFormState);
            //Fires a callback from the parent components, sending the newly 
            //create data upward to update tables or lists
            onSubmit(formData);
            onClose();
        } catch (err: any) {
            setError(err.message);            
        } finally{
            setLoading(false);
        }
    };

    return (
    <div className="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
      <div className="w-full max-w-2xl rounded-lg bg-white p-6 shadow-lg">
        <h2 className="mb-4 text-xl font-bold text-gray-800">Nuevo Producto</h2>

        {error && (
          <div className="mb-4 rounded bg-red-100 p-3 text-sm text-red-700">
            {error}
          </div>
        )}
        {/* onSubmit is a React event listener. It intercepts form submissions
        and runs the custom handleSubmit */}
        <form onSubmit={handleSubmit} className="space-y-4">
          <div className="grid grid-cols-2 gap-4">
            <div>
              <label className="block text-sm font-medium text-gray-700">Brand ID</label>
              <input
                type="number"
                name="brand_id"
                // This turns the input into a controlled component,
                // Tells this specific input field to read and display the current string
                // from the component's form state object
                value={formData.brand_id}
                onChange={handleChange}
                required
                className="mt-1 w-full rounded border p-2"
              />
            </div>

            <div>
              <label className="block text-sm font-medium text-gray-700">SKU</label>
              <input
                type="text"
                name="sku"
                value={formData.sku}
                onChange={handleChange}
                required
                className="mt-1 w-full rounded border p-2"
              />
            </div>

            <div>
              <label className="block text-sm font-medium text-gray-700">ERP Name</label>
              <input
                type="text"
                name="erp_name"
                value={formData.erp_name}
                onChange={handleChange}
                required
                className="mt-1 w-full rounded border p-2"
              />
            </div>

            <div>
              <label className="block text-sm font-medium text-gray-700">Technical Name</label>
              <input
                type="text"
                name="technical_name"
                value={formData.technical_name}
                onChange={handleChange}
                required
                className="mt-1 w-full rounded border p-2"
              />
            </div>

            <div>
              <label className="block text-sm font-medium text-gray-700">Guarantee Years</label>
              <input
                type="number"
                name="guarantee_years"
                value={formData.guarantee_years}
                onChange={handleChange}
                required
                className="mt-1 w-full rounded border p-2"
              />
            </div>

            <div>
              <label className="block text-sm font-medium text-gray-700">Volume (Liters)</label>
              <input
                type="number"
                step="0.01"
                name="volume_liters"
                value={formData.volume_liters}
                onChange={handleChange}
                required
                className="mt-1 w-full rounded border p-2"
              />
            </div>

            <div className="col-span-2">
              <label className="block text-sm font-medium text-gray-700">Base Type</label>
              <input
                type="text"
                name="base_type"
                value={formData.base_type}
                onChange={handleChange}
                required
                className="mt-1 w-full rounded border p-2"
              />
            </div>
          </div>

          <div className="flex gap-6 pt-2">
            <label className="flex items-center text-sm font-medium text-gray-700">
              <input
                type="checkbox"
                name="is_fibrated"
                // A specialized HTML/React property used explicitly for 
                // checkboxes instead of the standard value property
                checked={formData.is_fibrated}
                onChange={handleChange}
                className="mr-2"
              />
              Is Fibrated?
            </label>

            <label className="flex items-center text-sm font-medium text-gray-700">
              <input
                type="checkbox"
                name="requires_separate_primer"
                checked={formData.requires_separate_primer}
                onChange={handleChange}
                className="mr-2"
              />
              Requires Separate Primer?
            </label>
          </div>

          <div className="mt-6 flex justify-end gap-3">
            <button
              type="button"
              //A React event listener to capture mouse clicks or screen taps
              //to hide, close, or dismiss the current view or modal popup window
              onClick={onClose}
              className="rounded bg-gray-200 px-4 py-2 text-gray-700 hover:bg-gray-300"
            >
              Cancel
            </button>
            <button
              type="submit"
              //An HTML/React property used on buttons, inputs, and form fields
              // to toggle wheter a user can interact with them
              disabled={loading}
              className="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700 disabled:opacity-50"
            >
              {/* ok */}
              {loading ? 'Saving...' : 'Save Product'}
            </button>
          </div>
        </form>
      </div>
    </div>
  );
};
