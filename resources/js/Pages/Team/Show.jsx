import React from 'react';
import { Link, useForm } from '@inertiajs/react';
import CustomHeader from '@/Layouts/CustomHeader';
import {
    Box,
    Center,
    ChakraProvider,
    defaultSystem,
    HStack,
    Text,
    Badge,
    Button,
    Card,
    Image,
    VStack,
    CloseButton,
    Dialog,
    Portal
} from '@chakra-ui/react';


const Show = ({ team, m_event }) => {
    // console.log(team);
    // 編集フォームへの遷移時の処理

    // 削除ボタンクリック時の処理


    return (
        <ChakraProvider value={defaultSystem}>
            <>
                <CustomHeader />

                {/* メイン */}
                <Box className='main' width='80%' m='auto' bg="white" marginTop="20px" p="6" boxShadow="md" display="flex" justifyContent='center'>
                    <Box m='1rem'>
                        <Box maxW="md" m="auto">
                            <Center>
                                <Text fontSize='24px' p='1rem'>チーム詳細情報</Text>
                            </Center>
                        </Box>
                        <Card.Root flexDirection="row" overflow="hidden" maxW="2xl">
                            <Image
                                objectFit="cover"
                                maxW="200px"
                                src="/img/sport-img.jpg"
                            />
                            <Box flex="1" minW="0">
                                <Card.Body>
                                    <Card.Title mb="2">{team.team_name}</Card.Title>
                                    <Text marginBottom='1rem'>種目：{m_event.event_name}</Text>
                                    <Card.Description overflow="break-word" wordBreak="break-word">
                                        {team.memo}
                                    </Card.Description>
                                </Card.Body>
                                <Card.Footer>
                                    <HStack gap='4'>
                                        <Button as={Link} href={`/teams`} color='white' bg="gray.500" p='0.5rem'>一覧画面</Button>
                                        <Button as={Link} href={`/teams/edit/${team.id}`} color='white' bg="orange.400" p='0.5rem'>チーム情報編集</Button>
                                        <Button as={Link} href={`/teams`} color='white' bg="black" p='0.5rem'>削除</Button>
                                        <Dialog.Root>
                                            <Dialog.Trigger asChild>
                                                <Button variant="outline" size="md" color='white' bg='black' p='1rem'>
                                                    削除
                                                </Button>
                                            </Dialog.Trigger>
                                            <Portal>
                                                <Dialog.Backdrop />
                                                <Dialog.Positioner>
                                                    <Dialog.Content>
                                                        <Dialog.CloseTrigger asChild position="absolute" top="4" right="4">
                                                            <CloseButton size="md" position="absolute" top="4" right="4" />
                                                        </Dialog.CloseTrigger>
                                                        <Dialog.Header>
                                                            <Dialog.Title>削除前の最終確認</Dialog.Title>
                                                        </Dialog.Header>
                                                        <Dialog.Body>
                                                            <p>
                                                                このチームの登録情報を削除しますか。
                                                            </p>
                                                        </Dialog.Body>
                                                        <Dialog.Footer>
                                                            <Dialog.ActionTrigger asChild>
                                                                <Button variant="outline">キャンセル</Button>
                                                            </Dialog.ActionTrigger>
                                                            <Button color='white' bg='black' p='0.5rem'>削除する</Button>
                                                        </Dialog.Footer>
                                                    </Dialog.Content>
                                                </Dialog.Positioner>
                                            </Portal>
                                        </Dialog.Root>
                                    </HStack>
                                </Card.Footer>
                            </Box>
                        </Card.Root>
                    </Box>
                </Box>

            </>
        </ChakraProvider>
    );
}
export default Show;