import { InspectorControls, useBlockProps } from "@wordpress/block-editor";
import { useSelect } from "@wordpress/data";
import { PanelBody, ToggleControl, TextControl, DatePicker } from "@wordpress/components";
import { registerBlockType } from "@wordpress/blocks";
import metadata from "./block.json";
import { TextareaControl } from "@wordpress/components";
import Testimonial from "./Testimonial";

registerBlockType(metadata.name, {
  title: "CofC Testimonial",
  edit: ({ attributes, setAttributes, isSelected }) => {
    const { quote, name, date } = attributes;

    const onQuoteChange = (newQuote) => {
      setAttributes({ quote: newQuote });
    };

    const onNameChange = (newName) => {
      setAttributes({ name: newName });
    };

    const onDateChange = (newDate) => {
      setAttributes({ date: newDate });
    };

    // Use the useBlockProps hook to apply block props to the wrapper element
    const blockProps = useBlockProps({ className: `custom-block ${isSelected ? "is-selected" : ""}` });

    return (
      <div {...blockProps}>
        <InspectorControls>
          <PanelBody title="Block Settings" initialOpen={true}>
            <TextareaControl
              value={quote}
              onChange={onQuoteChange}
              help="What is the testimonial? Do not wrap the content in quotation marks."
              label="Testimonial"
            ></TextareaControl>
            <TextControl
              value={name}
              help="Who said this? Provide a full name."
              onChange={onNameChange}
              label="Name"
            ></TextControl>
            <DatePicker value={date} onChange={onDateChange} label="Date" help="When did they say this?"></DatePicker>
          </PanelBody>
        </InspectorControls>
        <div className="block-preview wp-block" style={{ border: "1px solid black", margin: "0.3rem" }}>
          <Testimonial attributes={attributes}></Testimonial>
        </div>
      </div>
    );
  },
  save: ({ attributes }) => {
    return <Testimonial attributes={attributes}></Testimonial>;
  },
});
