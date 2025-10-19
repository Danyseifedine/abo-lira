import type { VariantProps } from "class-variance-authority"
import { cva } from "class-variance-authority"

export { default as Badge } from "./Badge.vue"
export { default as Tag } from "./Tag.vue"

export const badgeVariants = cva(
  "inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2",
  {
    variants: {
      variant: {
        default:
          "border-transparent bg-primary text-primary-foreground hover:bg-primary/80",
        secondary:
          "border-transparent bg-secondary text-secondary-foreground hover:bg-secondary/80",
        destructive:
          "border-transparent bg-destructive text-destructive-foreground hover:bg-destructive/80",
        outline: "text-foreground",

        // New badge designs
        success:
          "border-transparent bg-green-500 text-white hover:bg-green-600",
        info:
          "border-transparent bg-blue-500 text-white hover:bg-blue-600",
        warning:
          "border-transparent bg-yellow-400 text-yellow-900 hover:bg-yellow-500",
        muted:
          "border-transparent bg-muted text-muted-foreground hover:bg-muted/80",
        dark:
          "border-transparent bg-gray-900 text-white hover:bg-gray-800",
        light:
          "border border-gray-200 bg-white text-gray-700 hover:bg-gray-50",
        pink:
          "border-transparent bg-pink-500 text-white hover:bg-pink-600",
      },
    },
    defaultVariants: {
      variant: "default",
    },
  }
)

export type BadgeVariants = VariantProps<typeof badgeVariants>
