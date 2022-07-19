<?php
namespace Symfony\Component\Console\Helper;
if (!defined('ABSPATH')) exit;
use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
class SymfonyQuestionHelper extends QuestionHelper
{
 protected function writePrompt(OutputInterface $output, Question $question)
 {
 $text = OutputFormatter::escapeTrailingBackslash($question->getQuestion());
 $default = $question->getDefault();
 switch (true) {
 case null === $default:
 $text = sprintf(' <info>%s</info>:', $text);
 break;
 case $question instanceof ConfirmationQuestion:
 $text = sprintf(' <info>%s (yes/no)</info> [<comment>%s</comment>]:', $text, $default ? 'yes' : 'no');
 break;
 case $question instanceof ChoiceQuestion && $question->isMultiselect():
 $choices = $question->getChoices();
 $default = explode(',', $default);
 foreach ($default as $key => $value) {
 $default[$key] = $choices[trim($value)];
 }
 $text = sprintf(' <info>%s</info> [<comment>%s</comment>]:', $text, OutputFormatter::escape(implode(', ', $default)));
 break;
 case $question instanceof ChoiceQuestion:
 $choices = $question->getChoices();
 $text = sprintf(' <info>%s</info> [<comment>%s</comment>]:', $text, OutputFormatter::escape($choices[$default] ?? $default));
 break;
 default:
 $text = sprintf(' <info>%s</info> [<comment>%s</comment>]:', $text, OutputFormatter::escape($default));
 }
 $output->writeln($text);
 $prompt = ' > ';
 if ($question instanceof ChoiceQuestion) {
 $output->writeln($this->formatChoiceQuestionChoices($question, 'comment'));
 $prompt = $question->getPrompt();
 }
 $output->write($prompt);
 }
 protected function writeError(OutputInterface $output, \Exception $error)
 {
 if ($output instanceof SymfonyStyle) {
 $output->newLine();
 $output->error($error->getMessage());
 return;
 }
 parent::writeError($output, $error);
 }
}
